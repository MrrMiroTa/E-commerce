@extends('layouts.dashboard')

@section('title', 'Add New Product')

@section('content')
<div class="max-w-3xl mx-auto">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Add New Product</h1>
            <p class="text-sm text-gray-500 mt-1">Fill in the details to add a product to your store</p>
        </div>
        <a href="{{ route('dashboard.stock') }}"
            class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 border border-gray-200 rounded-lg px-4 py-2 hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Stock
        </a>
    </div>

    <!-- Validation Errors -->
    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
            <p class="font-medium mb-1">Please fix the following errors:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('dashboard.products.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Product Image -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
            <h2 class="text-base font-semibold text-gray-800 mb-4">Product Image</h2>
            <div class="flex items-start gap-6">
                <div id="imagePreviewWrapper" class="w-32 h-32 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden border-2 border-dashed border-gray-200 flex-shrink-0">
                    <svg id="imagePlaceholder" class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <img id="imagePreview" src="" alt="Preview" class="w-full h-full object-cover hidden">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Image</label>
                    <input type="file" name="image" id="imageInput" accept="image/jpeg,image/png,image/jpg,image/webp"
                        onchange="previewImage(this)"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                    <p class="text-xs text-gray-400 mt-2">JPEG, PNG, WebP — max 2MB</p>
                </div>
            </div>
        </div>

        <!-- Basic Info -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
            <h2 class="text-base font-semibold text-gray-800 mb-4">Basic Information</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('name') border-red-400 bg-red-50 @enderror">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">SKU <span class="text-red-500">*</span> <span class="text-gray-400 text-xs">(Format: ABCD1234)</span></label>
                        <input type="text" name="sku" value="{{ old('sku') }}" required placeholder="ABCD1234"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('sku') border-red-400 bg-red-50 @enderror">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
                        <select name="category_id" required
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('category_id') border-red-400 bg-red-50 @enderror">
                            <option value="">Select category...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Pricing -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
            <h2 class="text-base font-semibold text-gray-800 mb-4">Pricing</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Regular Price ($) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-sm">$</span>
                        <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required
                            class="w-full pl-7 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('price') border-red-400 bg-red-50 @enderror">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sale Price ($) <span class="text-gray-400 font-normal">(optional)</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-sm">$</span>
                        <input type="number" name="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0"
                            class="w-full pl-7 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('sale_price') border-red-400 bg-red-50 @enderror"
                            placeholder="Leave blank for no sale">
                    </div>
                    @error('sale_price')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Stock -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
            <h2 class="text-base font-semibold text-gray-800 mb-4">Stock Management</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity <span class="text-red-500">*</span></label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('stock_quantity') border-red-400 bg-red-50 @enderror">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Min Stock Level <span class="text-red-500">*</span></label>
                    <input type="number" name="min_stock_level" value="{{ old('min_stock_level', 10) }}" min="0" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('min_stock_level') border-red-400 bg-red-50 @enderror">
                    <p class="text-xs text-gray-400 mt-1">Alert threshold for low stock warnings</p>
                </div>
            </div>
        </div>

        <!-- Visibility -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
            <h2 class="text-base font-semibold text-gray-800 mb-4">Visibility</h2>
            <div class="space-y-3">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" checked
                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <div>
                        <span class="text-sm font-medium text-gray-700">Active</span>
                        <p class="text-xs text-gray-400">Product is visible in the shop</p>
                    </div>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" value="1"
                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <div>
                        <span class="text-sm font-medium text-gray-700">Featured</span>
                        <p class="text-xs text-gray-400">Show on homepage featured section</p>
                    </div>
                </label>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('dashboard.stock') }}"
                class="px-5 py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit"
                class="px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 text-sm">
                Add Product
            </button>
        </div>

    </form>
</div>

@section('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('imagePlaceholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
@endsection
