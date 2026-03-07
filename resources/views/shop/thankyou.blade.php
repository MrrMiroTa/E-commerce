@extends('layouts.app')

@section('title', 'Thank You')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center">
        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Thank You for Your Order!</h1>
        <p class="text-gray-600 mb-8">Your order has been placed successfully. We'll send you an email confirmation shortly.</p>
        
        @auth
        @if($order && $order->user_id === auth()->id())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8 text-left">
            <div class="border-b pb-4 mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Order Details</h2>
                <p class="text-gray-500">Order #{{ $order->order_number }}</p>
            </div>
            
            <div class="space-y-3 mb-4">
                @foreach($order->items as $item)
                <div class="flex justify-between">
                    <div>
                        <p class="font-medium text-gray-800">{{ $item->product_name }}</p>
                        <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                    </div>
                    <p class="font-medium text-gray-800">${{ number_format($item->total, 2) }}</p>
                </div>
                @endforeach
            </div>
            
            <div class="border-t pt-4 space-y-2">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Shipping</span>
                    <span>${{ number_format($order->shipping_cost, 2) }}</span>
                </div>
                <div class="flex justify-between text-xl font-bold text-gray-800 pt-2 border-t">
                    <span>Total</span>
                    <span>${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>
        @endif
        @endauth
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('shop.index') }}" class="inline-flex items-center justify-center btn-primary text-white font-semibold py-3 px-8 rounded-lg hover:opacity-90 transition">
                Continue Shopping
            </a>
            <a href="{{ route('profile.show') }}" class="inline-flex items-center justify-center bg-gray-100 text-gray-800 font-semibold py-3 px-8 rounded-lg hover:bg-gray-200 transition">
                View Order Status
            </a>
            <button onclick="window.print()" class="inline-flex items-center justify-center bg-white border border-gray-300 text-gray-800 font-semibold py-3 px-8 rounded-lg hover:bg-gray-50 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print Receipt
            </button>
        </div>
    </div>
</div>
@endsection
