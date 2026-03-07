@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li><a href="{{ route('shop.index') }}" class="text-gray-500 hover:text-indigo-600">Shop</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li><a href="{{ route('shop.index', ['category' => $product->category_id]) }}" class="text-gray-500 hover:text-indigo-600">{{ $product->category->name }}</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li class="text-gray-900 font-medium">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Product Image -->
            <div class="relative">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-2xl shadow-lg">
                @else
                    <div class="w-full h-96 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl shadow-lg flex items-center justify-center">
                        <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
                @if($product->is_on_sale)
                    <span class="absolute top-4 left-4 badge-sale text-white text-sm font-bold px-4 py-2 rounded-full">SALE</span>
                @endif
            </div>

            <!-- Product Info -->
            <div class="flex flex-col">
                <span class="text-sm text-indigo-600 font-medium">{{ $product->category->name }}</span>
                <h1 class="text-3xl font-bold text-gray-900 mt-2 mb-4">{{ $product->name }}</h1>
                
                <div class="flex items-baseline gap-4 mb-6">
                    @if($product->is_on_sale)
                        <span class="text-3xl font-bold text-red-600">${{ number_format($product->current_price, 2) }}</span>
                        <span class="text-xl text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                        <span class="bg-red-100 text-red-600 text-sm font-medium px-3 py-1 rounded-full">
                            Save ${{ number_format($product->price - $product->current_price, 2) }}
                        </span>
                    @else
                        <span class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <!-- Stock Status -->
                <div class="flex items-center gap-2 mb-6">
                    @if($product->is_in_stock)
                        <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                        <span class="text-green-600 font-medium">In Stock ({{ $product->stock_quantity }} available)</span>
                    @else
                        <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                        <span class="text-red-600 font-medium">Out of Stock</span>
                    @endif
                </div>

                <p class="text-gray-600 mb-8 leading-relaxed">{{ $product->description }}</p>

                <!-- Add to Cart -->
                @if($product->is_in_stock)
                <div class="flex items-center gap-4 mb-8">
                    <div class="flex items-center border border-gray-300 rounded-lg">
                        <button type="button" onclick="decrementQuantity()" class="px-4 py-3 hover:bg-gray-100 transition">-</button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" 
                               class="w-16 text-center border-x border-gray-300 py-3 focus:outline-none">
                        <button type="button" onclick="incrementQuantity({{ $product->stock_quantity }})" class="px-4 py-3 hover:bg-gray-100 transition">+</button>
                    </div>
                    <button type="button" onclick="addToCartWithQuantity({{ $product->id }})" id="add-to-cart-btn" class="flex-1 btn-primary text-white font-semibold py-3 px-8 rounded-lg hover:opacity-90 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 add-cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <svg class="w-5 h-5 add-cart-spinner hidden animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="btn-text">Add to Cart</span>
                    </button>
                </div>
                @endif

                <!-- Product Details -->
                <div class="border-t pt-6 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">SKU:</span>
                        <span class="text-gray-900 font-medium">{{ $product->sku }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                <div class="product-card bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <a href="{{ route('shop.show', $relatedProduct) }}">
                        <div class="relative">
                            @if($relatedProduct->image)
                                <img src="{{ $relatedProduct->image }}" alt="{{ $relatedProduct->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            @if($relatedProduct->is_on_sale)
                                <span class="absolute top-2 right-2 badge-sale text-white text-xs font-bold px-2 py-1 rounded">SALE</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 hover:text-indigo-600 transition">{{ $relatedProduct->name }}</h3>
                            <div class="mt-2">
                                @if($relatedProduct->is_on_sale)
                                    <span class="text-lg font-bold text-red-600">${{ number_format($relatedProduct->current_price, 2) }}</span>
                                    <span class="text-sm text-gray-400 line-through">${{ number_format($relatedProduct->price, 2) }}</span>
                                @else
                                    <span class="text-lg font-bold text-gray-800">${{ number_format($relatedProduct->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    function incrementQuantity(max) {
        const input = document.getElementById('quantity');
        const current = parseInt(input.value);
        if (current < max) {
            input.value = current + 1;
        }
    }

    function decrementQuantity() {
        const input = document.getElementById('quantity');
        const current = parseInt(input.value);
        if (current > 1) {
            input.value = current - 1;
        }
    }
</script>
@endsection
