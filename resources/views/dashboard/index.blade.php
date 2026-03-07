@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded">Today</span>
        </div>
        <p class="text-sm text-gray-500 mb-1">Today's Orders</p>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($todayStats['orders']) }}</p>
    </div>

    <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded">Today</span>
        </div>
        <p class="text-sm text-gray-500 mb-1">Today's Revenue</p>
        <p class="text-2xl font-bold text-gray-800">${{ number_format($todayStats['revenue'], 2) }}</p>
    </div>

    <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <span class="text-xs font-medium text-purple-600 bg-purple-100 px-2 py-1 rounded">This Week</span>
        </div>
        <p class="text-sm text-gray-500 mb-1">Items Sold</p>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($weeklyStats->items_sold ?? 0) }}</p>
    </div>

    <div class="stat-card bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <span class="text-xs font-medium text-orange-600 bg-orange-100 px-2 py-1 rounded">Alert</span>
        </div>
        <p class="text-sm text-gray-500 mb-1">Low Stock Items</p>
        <p class="text-2xl font-bold text-gray-800">{{ $lowStockProducts->count() }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Sales Chart -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-6">Sales Trend (Last 7 Days)</h3>
        <canvas id="salesChart" height="200"></canvas>
    </div>

    <!-- Low Stock Alerts -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Low Stock Alerts</h3>
            <a href="{{ route('dashboard.stock') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View All</a>
        </div>
        
        @if($lowStockProducts->count() > 0)
            <div class="space-y-4">
                @foreach($lowStockProducts as $product)
                <div class="flex items-center gap-4 p-3 bg-red-50 rounded-lg border border-red-100">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-800 truncate">{{ $product->name }}</p>
                        <p class="text-sm text-red-600">
                            @if($product->stock_quantity == 0)
                                Out of Stock
                            @else
                                Only {{ $product->stock_quantity }} left
                            @endif
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-gray-600">All products are well stocked!</p>
            </div>
        @endif
    </div>
</div>

<!-- Recent Orders -->
<div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-800">Recent Orders</h3>
        <a href="{{ route('dashboard.orders') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View All Orders</a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-500">Order #</th>
                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-500">Customer</th>
                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-500">Items</th>
                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-500">Total</th>
                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-500">Status</th>
                    <th class="text-left py-3 px-4 text-sm font-medium text-gray-500">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="py-3 px-4">
                        <a href="{{ route('dashboard.orders') }}" class="text-indigo-600 hover:text-indigo-800 font-medium line-clamp-1">{{ $order->order_number }}</a>
                    </td>
                    <td class="py-3 px-4">
                        <p class="font-medium text-gray-800">{{ $order->customer_name }}</p>
                        <p class="text-sm text-gray-500">{{ $order->customer_email }}</p>
                    </td>
                    <td class="py-3 px-4 text-gray-600">{{ $order->items->sum('quantity') }} </td>
                    <td class="py-3 px-4 font-medium text-gray-800">${{ number_format($order->total, 2) }}</td>
                    <td class="py-3 px-4">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'shipped' => 'bg-purple-100 text-purple-800',
                                'delivered' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-gray-500 text-sm">{{ $order->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Revenue ($)',
                data: @json($chartRevenue),
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                fill: true,
                tension: 0.4
            }, {
                label: 'Orders',
                data: @json($chartOrders),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });
</script>
@endsection
