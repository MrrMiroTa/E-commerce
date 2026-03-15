@extends('layouts.dashboard')

@section('title', 'Orders')
@section('page-title', 'Order Management')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    @php
    $stats = [\App\Models\Order::where('status', 'pending')->count() ?? 0, \App\Models\Order::where('status', 'processing')->count() ?? 0, \App\Models\Order::where('status', 'shipped')->count() ?? 0, \App\Models\Order::whereDate('created_at', today())->count() ?? 0];
    $statLabels = ['Pending', 'Processing', 'Shipped', 'Today'];
    $statColors = ['yellow', 'blue', 'purple', 'green'];
    @endphp
    @foreach($stats as $index => $stat)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 font-medium">{{ $statLabels[$index] }}</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stat }}</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-{{ $statColors[$index] }}-100 flex items-center justify-center">
                @if($index === 0)
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                @elseif($index === 1)
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                @elseif($index === 2)
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                @else
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- New Orders Alert -->
@php $newPendingOrders = \App\Models\Order::where('status', 'pending')->orderByDesc('created_at')->take(5)->get(); @endphp
@if($newPendingOrders->isNotEmpty())
<div class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-xl p-4 mb-6 flex items-start gap-3">
    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
    </div>
    <div class="flex-1">
        <p class="font-bold text-yellow-800">{{ $newPendingOrders->count() }} Pending Order(s) Awaiting Action</p>
        <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            @foreach($newPendingOrders as $newOrder)
            <div class="bg-white rounded-lg p-3 border border-yellow-200 shadow-sm">
                <div class="flex items-center justify-between mb-1">
                    <span class="font-bold text-indigo-600 text-sm">#{{ $newOrder->order_number }}</span>
                    <span class="text-xs text-yellow-600 bg-yellow-100 px-2 py-0.5 rounded-full">Pending</span>
                </div>
                <p class="text-sm text-gray-700 font-medium">{{ $newOrder->customer_name }}</p>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-sm font-bold text-gray-800">${{ number_format($newOrder->total, 2) }}</span>
                    <span class="text-xs text-gray-400">{{ $newOrder->created_at->diffForHumans() }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <form action="{{ route('dashboard.orders') }}" method="GET" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500">
                <option value="all">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" 
                   class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" 
                   class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Order 4-digit number or customer..."
                   class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 w-64">
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
            Filter
        </button>
        <a href="{{ route('dashboard.orders') }}" class="text-gray-600 hover:text-gray-800 px-4 py-2">
            Reset
        </a>
    </form>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h3 class="text-lg font-bold text-gray-800">All Orders</h3>
        <div class="text-sm text-gray-500">
            Showing {{ $orders->count() }} orders
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">ID</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Total</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Payment</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Date</th>
                    <th class="text-left py-4 px-6 text-sm font-semibold text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition duration-150 cursor-pointer" onclick="toggleOrderDetails({{ $order->id }})">
                    <td class="py-4 px-6">
                        <span class="font-bold text-indigo-600">#{{ $order->id }}</span>
                    </td>
                    <td class="py-4 px-6">
                        <span class="text-lg font-bold text-gray-800">${{ number_format($order->total, 2) }}</span>
                    </td>
                    <td class="py-4 px-6">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                                'shipped' => 'bg-purple-100 text-purple-700 border-purple-200',
                                'delivered' => 'bg-green-100 text-green-700 border-green-200',
                                'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $order->status === 'pending' ? 'bg-yellow-500' : ($order->status === 'processing' ? 'bg-blue-500' : ($order->status === 'shipped' ? 'bg-purple-500' : ($order->status === 'delivered' ? 'bg-green-500' : 'bg-red-500'))) }}"></span>
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</p>
                    </td>
                    <td class="py-4 px-6">
                        <button onclick="event.stopPropagation(); openOrderDetailsModal({{ $order->id }}, '{{ $order->order_number }}')" 
                                class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 font-medium text-sm bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            View
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-16 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500 text-lg font-medium">No orders found</p>
                            <p class="text-gray-400 text-sm mt-1">Orders will appear here when customers place them.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($orders->hasPages())
    <div class="p-4 border-t border-gray-100">
        {{ $orders->links() }}
    </div>
    @endif
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Order Status</h3>
        <p id="modalOrderNumber" class="text-gray-600 mb-4"></p>
        
        <form id="statusUpdateForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">New Status</label>
                <select name="status" id="modalStatus" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500">
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeStatusModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Order Details Modal -->
<div id="orderDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full mx-4 p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">Order Details</h3>
            <button onclick="closeOrderDetailsModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <div id="orderDetailsContent" class="space-y-6">
            <!-- Content loaded via AJAX -->
            <div class="text-center py-8">
                <svg class="animate-spin h-8 w-8 text-indigo-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="mt-2 text-gray-500">Loading order details...</p>
            </div>
        </div>
        
        <div class="mt-6 pt-4 border-t border-gray-200 flex gap-3">
            <button onclick="closeOrderDetailsModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Close
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openStatusModal(orderId, orderNumber, currentStatus) {
        const modal = document.getElementById('statusModal');
        const form = document.getElementById('statusUpdateForm');
        const orderEl = document.getElementById('modalOrderNumber');
        const statusEl = document.getElementById('modalStatus');
        
        form.action = `{{ url('dashboard/orders') }}/${orderId}/status`;
        orderEl.textContent = `Order #${orderNumber}`;
        statusEl.value = currentStatus;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeStatusModal() {
        const modal = document.getElementById('statusModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    function openOrderDetailsModal(orderId, orderNumber) {
        const modal = document.getElementById('orderDetailsModal');
        const content = document.getElementById('orderDetailsContent');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Load order details via fetch
        fetch(`https://${window.location.host}/dashboard/orders/${orderId}/details`)
            .then(response => response.text())
            .then(html => {
                content.innerHTML = html;
            })
            .catch(error => {
                content.innerHTML = `<div class="text-center py-8 text-red-500">Error loading order details</div>`;
            });
    }
    
    function closeOrderDetailsModal() {
        const modal = document.getElementById('orderDetailsModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    // Close modal on outside click
    document.getElementById('statusModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeStatusModal();
        }
    });
    
    document.getElementById('orderDetailsModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeOrderDetailsModal();
        }
    });
</script>
@endsection
