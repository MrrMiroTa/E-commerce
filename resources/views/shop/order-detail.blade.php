@extends('layouts.app')

@section('title')Order #{{ $order->order_number }}@endsection

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- Back link -->
    <div class="mb-6">
        <a href="{{ route('profile.show') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to My Profile
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <!-- Header -->
        <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Order #{{ $order->order_number }}</h1>
                <p class="text-sm text-gray-500 mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-block px-3 py-1 text-sm rounded-full font-semibold
                    @if($order->status === 'completed') bg-green-100 text-green-700
                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-700
                    @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                    @else bg-red-100 text-red-700
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
                <button onclick="window.print()" class="inline-flex items-center bg-white border border-gray-300 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg hover:bg-gray-50 transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print Receipt
                </button>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="px-6 py-5 border-b border-gray-100 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Customer</p>
                <p class="text-gray-800 font-medium">{{ $order->customer_name }}</p>
                <p class="text-gray-500 text-sm">{{ $order->customer_email }}</p>
                @if($order->customer_phone)
                    <p class="text-gray-500 text-sm">{{ $order->customer_phone }}</p>
                @endif
            </div>
            @if($order->shipping_address)
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Shipping Address</p>
                <p class="text-gray-800 text-sm whitespace-pre-line">{{ $order->shipping_address }}</p>
            </div>
            @endif
        </div>

        <!-- Order Items -->
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">Items Ordered</h2>
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">{{ $item->product_name }}</p>
                            <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × ${{ number_format($item->unit_price, 2) }}</p>
                        </div>
                    </div>
                    <p class="font-semibold text-gray-800 whitespace-nowrap">${{ number_format($item->total, 2) }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Order Totals -->
        <div class="px-6 py-5">
            <div class="space-y-2 max-w-xs ml-auto">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Shipping</span>
                    <span>
                        @if($order->shipping_cost == 0)
                            <span class="text-green-600">Free</span>
                        @else
                            ${{ number_format($order->shipping_cost, 2) }}
                        @endif
                    </span>
                </div>
                <div class="flex justify-between text-lg font-bold text-gray-800 pt-3 border-t">
                    <span>Total</span>
                    <span>${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
