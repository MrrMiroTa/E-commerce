@extends('layouts.app')

@section('title', 'Shop')

@section('content')
<!-- Hero Section -->
<section class="gradient-bg text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to UAShop</h1>
            <p class="text-xl opacity-90 mb-8">Discover amazing products at unbeatable prices</p>
            <a href="#products" class="inline-block bg-white text-indigo-600 font-semibold px-8 py-3 rounded-full hover:bg-gray-100 transition">
                Shop Now
            </a>
        </div>
    </div>
</section>

<!-- Featured Products -->
@if($featuredProducts->count() > 0)
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-8">Featured Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
            <div class="product-card bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="relative">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    @if($product->is_on_sale)
                        <span class="absolute top-2 right-2 badge-sale text-white text-xs font-bold px-2 py-1 rounded">SALE</span>
                    @endif
                    @if(!$product->is_in_stock)
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                            <span class="bg-gray-800 text-white px-3 py-1 rounded text-sm">Out of Stock</span>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    <span class="text-xs text-indigo-600 font-medium">{{ $product->category->name }}</span>
                    <h3 class="font-semibold text-gray-800 mt-1 mb-2">{{ $product->name }}</h3>
                    <div class="flex items-center justify-between">
                        <div>
                            @if($product->is_on_sale)
                                <span class="text-lg font-bold text-red-600">${{ number_format($product->current_price, 2) }}</span>
                                <span class="text-sm text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                            @else
                                <span class="text-lg font-bold text-gray-800">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        @if($product->is_in_stock)
                            <button type="button" onclick="addToCart({{ $product->id }}, 1)" 
                                    class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center hover:bg-indigo-700 transition"
                                    {{-- aria-label="Add {{ $product->name }} to cart" --}}>
                                <svg class="w-5 h-5 add-cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <svg class="w-5 h-5 add-cart-spinner hidden animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Products Section -->
<section id="products" class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">All Products</h2>
            
            <!-- Filters -->
            <div class="flex flex-wrap items-center gap-4">
                <form action="{{ route('shop.index') }}" method="GET" class="flex items-center gap-2">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <select name="sort" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <h3 class="font-semibold text-gray-800 mb-4">Categories</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('shop.index', array_merge(request()->except('category'), ['sort' => request('sort')])) }}" 
                               class="block py-2 px-3 rounded-lg {{ !request('category') ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50' }}">
                                All Categories
                            </a>
                        </li>
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('shop.index', array_merge(request()->all(), ['category' => $category->id])) }}" 
                               class="block py-2 px-3 rounded-lg {{ request('category') == $category->id ? 'bg-indigo-50 text-indigo-600' : 'text-gray-600 hover:bg-gray-50' }}">
                                {{ $category->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="flex-1">
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                        <div class="product-card bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                            <a href="{{ route('shop.show', $product) }}" class="block">
                                <div class="relative">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    @if($product->is_on_sale)
                                        <span class="absolute top-2 right-2 badge-sale text-white text-xs font-bold px-2 py-1 rounded">SALE</span>
                                    @endif
                                    @if(!$product->is_in_stock)
                                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                            <span class="bg-gray-800 text-white px-3 py-1 rounded text-sm">Out of Stock</span>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <div class="p-4">
                                <span class="text-xs text-indigo-600 font-medium">{{ $product->category->name }}</span>
                                <a href="{{ route('shop.show', $product) }}">
                                    <h3 class="font-semibold text-gray-800 mt-1 mb-2 hover:text-indigo-600 transition">{{ $product->name }}</h3>
                                </a>
                                <div class="flex items-center justify-between">
                                    <div>
                                        @if($product->is_on_sale)
                                            <span class="text-lg font-bold text-red-600">${{ number_format($product->current_price, 2) }}</span>
                                            <span class="text-sm text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                                        @else
                                            <span class="text-lg font-bold text-gray-800">${{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                    @if($product->is_in_stock)
                                        <form action="{{ route('shop.cart.add', $product) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center hover:bg-indigo-700 transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900">No products found</h3>
                        <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
