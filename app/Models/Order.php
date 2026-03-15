<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'subtotal',
        'tax',
        'shipping_cost',
        'total',
        'status',
        'payment_status',
        'payment_method',
        'notes',
        'completed_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public static function generateOrderNumber(): string
    {
        // Generate order number with format: #ORD-Y-M-D-001
        $prefix = '#ORD';
        $date = now()->format('Ymd');
        
        // Get the last order created today to increment the number
        $lastOrder = self::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastOrder) {
            // Extract the last order number and increment
            $lastNumber = $lastOrder->order_number;
            $lastDate = substr($lastNumber, 5, 8); // Extract date part
            
            if ($lastDate === $date) {
                // Same day, increment the counter
                $lastCounter = (int)substr($lastNumber, -3);
                $newCounter = str_pad($lastCounter + 1, 3, '0', STR_PAD_LEFT);
            } else {
                // New day, reset counter
                $newCounter = '001';
            }
        } else {
            $newCounter = '001';
        }
        
        return "{$prefix}-{$date}-{$newCounter}";
    }
}
