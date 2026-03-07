<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DailySale extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'total_orders',
        'total_items_sold',
        'total_revenue',
        'total_cost',
        'profit',
    ];

    protected $casts = [
        'date' => 'date',
        'total_revenue' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'profit' => 'decimal:2',
    ];

    public function scopeToday($query)
    {
        return $query->where('date', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()]);
    }

    public function scopeThisYear($query)
    {
        return $query->whereBetween('date', [now()->startOfYear(), now()->endOfYear()]);
    }

    public static function recordSale(float $revenue, int $itemsCount = 1, ?float $cost = null): self
    {
        return DB::transaction(function () use ($revenue, $itemsCount, $cost) {
            $today = today();

            // Use atomic database operations to prevent race conditions
            $dailySale = self::firstOrCreate(
                ['date' => $today],
                [
                    'total_orders' => 0,
                    'total_items_sold' => 0,
                    'total_revenue' => 0,
                    'total_cost' => 0,
                    'profit' => 0,
                ]
            );

            // Use database-level atomic increments
            $updateData = [
                'total_orders' => DB::raw('total_orders + 1'),
                'total_items_sold' => DB::raw("total_items_sold + {$itemsCount}"),
                'total_revenue' => DB::raw("total_revenue + {$revenue}"),
            ];

            if ($cost !== null) {
                $updateData['total_cost'] = DB::raw("total_cost + {$cost}");
            }

            // Lock the row and update atomically
            self::where('id', $dailySale->id)->lockForUpdate()->update($updateData);

            // Recalculate profit atomically
            self::where('id', $dailySale->id)->update([
                'profit' => DB::raw('total_revenue - total_cost'),
            ]);

            // Refresh and return the updated model
            return $dailySale->fresh();
        });
    }
}
