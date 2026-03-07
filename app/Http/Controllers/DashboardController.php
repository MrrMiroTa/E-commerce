<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DailySale;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Today's statistics
        $today = DailySale::today()->first();
        $todayStats = [
            'orders' => $today?->total_orders ?? 0,
            'revenue' => $today?->total_revenue ?? 0,
            'items_sold' => $today?->total_items_sold ?? 0,
            'profit' => $today?->profit ?? 0,
        ];

        // Weekly statistics
        $weeklyStats = DailySale::thisWeek()
            ->selectRaw('SUM(total_orders) as orders, SUM(total_revenue) as revenue, SUM(total_items_sold) as items_sold, SUM(profit) as profit')
            ->first();

        // Monthly statistics
        $monthlyStats = DailySale::thisMonth()
            ->selectRaw('SUM(total_orders) as orders, SUM(total_revenue) as revenue, SUM(total_items_sold) as items_sold, SUM(profit) as profit')
            ->first();

        // Low stock products
        $lowStockProducts = Product::where(function ($query) {
                $query->whereColumn('stock_quantity', '<=', 'min_stock_level')
                      ->orWhere('stock_quantity', 0);
            })
            ->with('category')
            ->orderBy('stock_quantity', 'asc')
            ->take(10)
            ->get();

        // Recent orders
        $recentOrders = Order::with('items')
            ->latest()
            ->take(10)
            ->get();

        // Sales chart data (last 7 days)
        $last7Days = DailySale::where('date', '>=', now()->subDays(6))
            ->orderBy('date')
            ->get();

        $chartLabels = $last7Days->pluck('date')->map(fn($d) => $d->format('M d'))->toArray();
        $chartRevenue = $last7Days->pluck('total_revenue')->toArray();
        $chartOrders = $last7Days->pluck('total_orders')->toArray();

        return view('dashboard.index', compact(
            'todayStats',
            'weeklyStats',
            'monthlyStats',
            'lowStockProducts',
            'recentOrders',
            'chartLabels',
            'chartRevenue',
            'chartOrders'
        ));
    }

    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $dailySales = DailySale::whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->paginate(30);

        $summary = DailySale::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('
                SUM(total_orders) as total_orders,
                SUM(total_items_sold) as total_items,
                SUM(total_revenue) as total_revenue,
                SUM(total_cost) as total_cost,
                SUM(profit) as total_profit
            ')
            ->first();

        return view('dashboard.sales', compact('dailySales', 'summary', 'startDate', 'endDate'));
    }

    public function stock(Request $request)
    {
        $query = Product::with('category');

        // Filter by stock status
        if ($request->has('status')) {
            switch ($request->status) {
                case 'low':
                    $query->whereColumn('stock_quantity', '<=', 'min_stock_level')
                          ->where('stock_quantity', '>', 0);
                    break;
                case 'out':
                    $query->where('stock_quantity', 0);
                    break;
                case 'in':
                    $query->whereColumn('stock_quantity', '>', 'min_stock_level');
                    break;
            }
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->orderBy('stock_quantity', 'asc')->paginate(20);

        // Stock summary
        $totalProducts = Product::count();
        $lowStockCount = Product::whereColumn('stock_quantity', '<=', 'min_stock_level')
            ->where('stock_quantity', '>', 0)
            ->count();
        $outOfStockCount = Product::where('stock_quantity', 0)->count();
        $totalStockValue = Product::selectRaw('SUM(stock_quantity * price) as total')->first()->total ?? 0;

        return view('dashboard.stock', compact(
            'products',
            'totalProducts',
            'lowStockCount',
            'outOfStockCount',
            'totalStockValue'
        ));
    }

    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
            'min_stock_level' => 'nullable|integer|min:0',
        ]);

        $product->stock_quantity = $request->quantity;
        if ($request->has('min_stock_level')) {
            $product->min_stock_level = $request->min_stock_level;
        }
        $product->save();

        return back()->with('success', 'Stock updated successfully!');
    }

    public function orders(Request $request)
    {
        $query = Order::with('items');

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by order number or customer
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(20);

        return view('dashboard.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->status = $request->status;
        if ($request->status === 'delivered') {
            $order->completed_at = now();
        }
        $order->save();

        return back()->with('success', 'Order status updated successfully!');
    }

    public function createProduct()
    {
        $categories = Category::orderBy('name')->get();
        return view('dashboard.product-create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'required|numeric|min:0',
            'sale_price'      => 'nullable|numeric|min:0|lt:price',
            'stock_quantity'  => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'sku'             => 'required|string|max:100|unique:products,sku',
            'category_id'     => 'required|exists:categories,id',
            'is_active'       => 'boolean',
            'is_featured'     => 'boolean',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'            => $request->name,
            'description'     => $request->description,
            'price'           => $request->price,
            'sale_price'      => $request->sale_price ?: null,
            'stock_quantity'  => $request->stock_quantity,
            'min_stock_level' => $request->min_stock_level,
            'sku'             => $request->sku,
            'category_id'     => $request->category_id,
            'is_active'       => $request->boolean('is_active', true),
            'is_featured'     => $request->boolean('is_featured'),
            'image'           => $imagePath,
        ]);

        return redirect()->route('dashboard.stock')->with('success', 'Product created successfully!');
    }

    public function editProduct(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('dashboard.product-edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'required|numeric|min:0',
            'sale_price'      => 'nullable|numeric|min:0|lt:price',
            'stock_quantity'  => 'required|integer|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'sku'             => 'required|string|max:100|unique:products,sku,' . $product->id,
            'category_id'     => 'required|exists:categories,id',
            'is_active'       => 'boolean',
            'is_featured'     => 'boolean',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name'            => $request->name,
            'description'     => $request->description,
            'price'           => $request->price,
            'sale_price'      => $request->sale_price ?: null,
            'stock_quantity'  => $request->stock_quantity,
            'min_stock_level' => $request->min_stock_level,
            'sku'             => $request->sku,
            'category_id'     => $request->category_id,
            'is_active'       => $request->boolean('is_active'),
            'is_featured'     => $request->boolean('is_featured'),
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('dashboard.stock')->with('success', "Product \"{$product->name}\" updated successfully!");
    }
}
