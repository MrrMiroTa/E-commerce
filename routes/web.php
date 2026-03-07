<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// Shop Routes (Public)
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/products/{product:slug}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/category/{category:slug}', [ShopController::class, 'category'])->name('shop.category');

// Static Pages
Route::get('/contact', function () { return view('shop.contact'); })->name('shop.contact');
Route::get('/faq', function () { return view('shop.faq'); })->name('shop.faq');
Route::get('/shipping', function () { return view('shop.shipping'); })->name('shop.shipping');

// Cart Routes (Public)
Route::get('/cart', [CartController::class, 'index'])->name('shop.cart');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('shop.cart.add');
Route::put('/cart/update/{product}', [CartController::class, 'update'])->name('shop.cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('shop.cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('shop.cart.clear');
Route::get('/cart/count', [CartController::class, 'count'])->name('shop.cart.count');

// Authentication Routes (Guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Checkout (Requires login)
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('shop.checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('shop.checkout.store');
    Route::get('/thank-you', [CheckoutController::class, 'thankyou'])->name('shop.thankyou');
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile (All authenticated users)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/orders/{order}', [ProfileController::class, 'showOrder'])->name('profile.order');

    // Dashboard Routes (Admin only)
    Route::middleware('admin')->prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/sales', [DashboardController::class, 'sales'])->name('sales');
        Route::get('/stock', [DashboardController::class, 'stock'])->name('stock');
        Route::put('/stock/{product}', [DashboardController::class, 'updateStock'])->name('stock.update');
        Route::get('/orders', [DashboardController::class, 'orders'])->name('orders');
        Route::put('/orders/{order}/status', [DashboardController::class, 'updateOrderStatus'])->name('orders.status');
        // Product management
        Route::get('/products/create', [DashboardController::class, 'createProduct'])->name('products.create');
        Route::post('/products', [DashboardController::class, 'storeProduct'])->name('products.store');
        Route::get('/products/{product}/edit', [DashboardController::class, 'editProduct'])->name('products.edit');
        Route::post('/products/{product}', [DashboardController::class, 'updateProduct'])->name('products.update');
    });
});
