@extends('layouts.dashboard')

@section('title', 'Stock Management')
@section('page-title', 'Stock Management')

@section('content')
<!-- Page Header -->
<div class="flex items-center justify-between mb-6">
    <div></div>
    <a href="{{ route('dashboard.products.create') }}"
        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Add Product
    </a>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <p class="text-sm text-gray-500 mb-1">Total Products</p>
        <p class="text-3xl font-bold text-gray-800">{{ number_format($totalProducts) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <p class="text-sm text-gray-500 mb-1">Low Stock</p>
        <p class="text-3xl font-bold text-orange-600">{{ number_format($lowStockCount) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <p class="text-sm text-gray-500 mb-1">Out of Stock</p>
        <p class="text-3xl font-bold text-red-600">{{ number_format($outOfStockCount) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <p class="text-sm text-gray-500 mb-1">Stock Value</p>
        <p class="text-3xl font-bold text-green-600">${{ number_format($totalStockValue, 2) }}</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <form action="{{ route('dashboard.stock') }}" method="GET" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Stock Status</label>
            <select name="status" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500">
                <option value="">All Products</option>
                <option value="low" {{ request('status') == 'low' ? 'selected' : '' }}>Low Stock</option>
                <option value="out" {{ request('status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                <option value="in" {{ request('status') == 'in' ? 'selected' : '' }}>In Stock</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Product name or SKU..."
                   class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 w-64">
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
            Filter
        </button>
        <a href="{{ route('dashboard.stock') }}" class="text-gray-600 hover:text-gray-800 px-4 py-2">
            Reset
        </a>
    </form>
</div>

<!-- Products Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-500">Product</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-500">SKU</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-500">Category</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-500">Current Stock</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-500">Min. Level</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-500">Status</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="border-b border-gray-50 text-xs hover:bg-gray-50 transition">
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $product->name }}</p>
                                <p class="text-sm text-gray-500">${{ number_format($product->current_price, 2) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-gray-600">{{ $product->sku }}</td>
                    <td class="py-4 px-6 text-gray-600">{{ $product->category->name }}</td>
                    <td class="py-4 px-6">
                        <span class="font-medium {{ $product->stock_quantity == 0 ? 'text-red-600' : ($product->is_low_stock ? 'text-orange-600' : 'text-green-600') }}">
                            {{ $product->stock_quantity }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-gray-600">{{ $product->min_stock_level }}</td>
                    <td class="py-4 px-6">
                        @if($product->stock_quantity == 0)
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Out of Stock</span>
                        @elseif($product->is_low_stock)
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">Low Stock</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">In Stock</span>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <button onclick="openStockModal({{ $product->id }}, '{{ $product->name }}', {{ $product->stock_quantity }}, {{ $product->min_stock_level }})"
                                    class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                Update Stock
                            </button>
                            <a href="{{ route('dashboard.products.edit', $product) }}"
                               class="text-gray-500 hover:text-gray-800 font-medium text-sm">
                                Edit
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-12 text-center text-gray-500">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <p>No products found.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($products->hasPages())
    <div class="p-4 border-t border-gray-100">
        {{ $products->links() }}
    </div>
    @endif
</div>

<!-- Stock Update Modal -->
<div id="stockModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Update Stock</h3>
        <p id="modalProductName" class="text-gray-600 mb-4"></p>
        
        <form id="stockUpdateForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Quantity</label>
                <input type="number" name="quantity" id="modalQuantity" min="0" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500">
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Minimum Stock Level</label>
                <input type="number" name="min_stock_level" id="modalMinLevel" min="0" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500">
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeStockModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openStockModal(productId, productName, currentStock, minLevel) {
        const modal = document.getElementById('stockModal');
        const form = document.getElementById('stockUpdateForm');
        const nameEl = document.getElementById('modalProductName');
        const quantityEl = document.getElementById('modalQuantity');
        const minLevelEl = document.getElementById('modalMinLevel');
        
        form.action = `{{ url('dashboard/stock') }}/${productId}`;
        nameEl.textContent = productName;
        quantityEl.value = currentStock;
        minLevelEl.value = minLevel;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeStockModal() {
        const modal = document.getElementById('stockModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    // Close modal on outside click
    document.getElementById('stockModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeStockModal();
        }
    });
</script>
@endsection
