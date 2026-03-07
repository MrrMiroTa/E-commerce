@extends('layouts.app')

@section('title', __('messages.cart'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ __('messages.cart') }}</h1>

    @if(count($cartItems) > 0)
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items -->
            <div class="flex-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    @foreach($cartItems as $item)
                    <div class="p-6 border-b border-gray-100 last:border-b-0 flex items-center gap-6">
                        <!-- Product Image -->
                        <div class="w-24 h-24 flex-shrink-0">
                            {{-- @if($item['product']->image)
                                <img src="{{ $item['product']->image }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover rounded-lg">
                            @else --}}
                                <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                             
                        </div>

                        <!-- Product Info -->
                        <div class="flex-1">
                            <a href="{{ route('shop.show', $item['product']) }}" class="font-semibold text-gray-800 hover:text-indigo-600 transition">
                                {{ $item['product']->name }}
                            </a>
                            <p class="text-sm text-gray-500 mt-1">{{ $item['product']->category->name }}</p>
                            @if($item['product']->is_low_stock)
                                <p class="text-xs text-orange-500 mt-1">Only {{ $item['product']->stock_quantity }} left!</p>
                            @endif
                        </div>

                        <!-- Quantity -->
                        <div class="flex items-center">
                            <form action="{{ route('shop.cart.update', $item['product']) }}" method="POST" class="flex items-center">
                                @csrf
                                @method('PUT')
                                <button type="button" onclick="updateQuantity(this, -1, {{ $item['product']->stock_quantity }})" class="w-8 h-8 border border-gray-300 rounded-l hover:bg-gray-100 flex items-center justify-center">-</button>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock_quantity }}" 
                                       class="w-12 h-8 border-t border-b border-gray-300 text-center text-sm focus:outline-none">
                                <button type="button" onclick="updateQuantity(this, 1, {{ $item['product']->stock_quantity }})" class="w-8 h-8 border border-gray-300 rounded-r hover:bg-gray-100 flex items-center justify-center">+</button>
                                <button type="submit" class="hidden update-btn">Update</button>
                            </form>
                        </div>

                        <!-- Price -->
                        <div class="text-right min-w-[100px]">
                            <p class="font-semibold text-gray-800">${{ number_format($item['total'], 2) }}</p>
                            <p class="text-sm text-gray-500">${{ number_format($item['price'], 2) }} each</p>
                        </div>

                        <!-- Remove -->
                        <form action="{{ route('shop.cart.remove', $item['product']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>

                <!-- Continue Shopping -->
                <div class="mt-6">
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="w-full lg:w-96">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Order Summary</h2>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        {{-- Tax and Shipping calculations are disabled
                        <div class="flex justify-between text-gray-600">
                            <span>Tax (10%)</span>
                            <span>${{ number_format($total * 0.1, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            @if($total > 100)
                                <span class="text-green-600">Free</span>
                            @else
                                <span>$10.00</span>
                            @endif
                        </div>
                        --}}
                    </div>

                    <div class="border-t pt-4 mb-6">
                        <div class="flex justify-between text-xl font-bold text-gray-800">
                            <span>Total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        {{-- Free shipping upsell message disabled
                        @if($total <= 100)
                            <p class="text-sm text-gray-500 mt-2">Add ${{ number_format(100 - $total, 2) }} more for free shipping!</p>
                        @endif
                        --}}
                    </div>

                    @auth
                    <a href="{{ route('shop.checkout') }}" class="block w-full btn-primary text-white font-semibold py-3 px-8 rounded-lg hover:opacity-90 transition text-center">
                        Proceed to Checkout
                    </a>
                    @else
                    <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 text-center">
                        <p class="text-gray-700 mb-3">Please login to complete your checkout</p>
                        <div class="flex gap-2 justify-center">
                            <a href="{{ route('login') }}?redirect={{ route('shop.cart') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">Login</a>
                            <a href="{{ route('register') }}" class="bg-white text-indigo-600 border border-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-50 transition">Register</a>
                        </div>
                    </div>
                    @endauth

                    <form action="{{ route('shop.cart.clear') }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="block w-full text-gray-500 hover:text-red-600 transition text-center text-sm">
                            Clear Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Your cart is empty</h2>
            <p class="text-gray-500 mb-6">Looks like you haven't added any products to your cart yet.</p>
            <a href="{{ route('shop.index') }}" class="inline-block btn-primary text-white font-semibold py-3 px-8 rounded-lg hover:opacity-90 transition">
                Start Shopping
            </a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    function updateQuantity(btn, change, max) {
        const form = btn.closest('form');
        const input = form.querySelector('input[name="quantity"]');
        const current = parseInt(input.value);
        const newValue = current + change;
        
        if (newValue >= 1 && newValue <= max) {
            input.value = newValue;
            form.querySelector('.update-btn').click();
        }
    }
</script>
@endsection
