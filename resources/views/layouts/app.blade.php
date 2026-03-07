<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Shop') | {{ config('app.name', 'E-Commerce') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom Styles -->
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .product-card { transition: all 0.3s ease; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .btn-primary:hover { opacity: 0.9; }
        .badge-sale { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    </style>
    
    @yield('styles')
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('shop.index') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 gradient-bg rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-xl text-gray-800">UAShop</span>
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex items-center flex-1 max-w-lg mx-8">
                    <form action="{{ route('shop.index') }}" method="GET" class="w-full">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Search products..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-full focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </form>
                </div>

                <!-- Right Navigation -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('shop.cart') }}" class="relative p-2 text-gray-600 hover:text-indigo-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        @php
                            $cart = session('cart', []);
                            $cartCount = array_sum(array_column($cart, 'quantity'));
                        @endphp
                        @if($cartCount > 0)
                            <span id="cart-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                    
                    <!-- Info Links -->
                    <div class="hidden md:flex items-center space-x-2">
                        <a href="{{ route('shop.shipping') }}" class="p-2 text-gray-600 hover:text-indigo-600 transition text-sm" title="Shipping Info">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                        </a>
                        <a href="{{ route('shop.faq') }}" class="p-2 text-gray-600 hover:text-indigo-600 transition text-sm" title="FAQ">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </a>
                        <a href="{{ route('shop.contact') }}" class="p-2 text-gray-600 hover:text-indigo-600 transition text-sm" title="Contact Us">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </a>
                    </div>
                    
                    @auth
                        @if(Auth::user()->isAdmin())
                        <a href="{{ route('dashboard.index') }}" class="p-2 text-gray-600 hover:text-indigo-600 transition" title="Dashboard">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </a>
                        @endif
                        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open" class="flex items-center space-x-1 text-gray-600 hover:text-indigo-600 transition p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </button>
                            <div x-show="open" x-transition
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 border border-gray-100 z-50">
                                <span class="block px-4 py-2 text-sm text-gray-700 border-b">
                                    {{ Auth::user()->name }}
                                    <span class="ml-1 text-xs px-1.5 py-0.5 rounded {{ Auth::user()->isAdmin() ? 'bg-indigo-100 text-indigo-700' : 'bg-green-100 text-green-700' }}">
                                        {{ ucfirst(Auth::user()->role) }}
                                    </span>
                                </span>
                                <a href="{{ route('profile.show') }}" @click="open = false" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary text-white px-4 py-2 rounded-lg font-medium hover:opacity-90 transition">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">ShopHub</h3>
                    <p class="text-gray-400 text-sm">Your one-stop destination for quality products at unbeatable prices.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('shop.index') }}" class="hover:text-white">Shop</a></li>
                        <li><a href="{{ route('shop.cart') }}" class="hover:text-white">Cart</a></li>
                        <li><a href="{{ route('dashboard.index') }}" class="hover:text-white">Dashboard</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Customer Service</h3>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="{{ route('shop.contact') }}" class="hover:text-white">Contact Us</a></li>
                        <li><a href="{{ route('shop.faq') }}" class="hover:text-white">FAQs</a></li>
                        <li><a href="{{ route('shop.shipping') }}" class="hover:text-white">Shipping Info</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Newsletter</h3>
                    <p class="text-gray-400 text-sm mb-3">Subscribe for updates and exclusive offers.</p>
                    <div class="flex">
                        <input type="email" placeholder="Enter your email" class="flex-1 px-3 py-2 bg-gray-700 rounded-l text-sm focus:outline-none">
                        <button class="px-4 py-2 bg-indigo-600 rounded-r text-sm hover:bg-indigo-700">Subscribe</button>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} UAShop. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Cart Toast Notification -->
    <div id="cart-toast" class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-20 opacity-0 transition-all duration-300 z-50">
        <span id="cart-toast-message"></span>
    </div>

    @yield('scripts')
    
    <!-- AJAX Cart Scripts -->
    <script>
        function addToCart(productId, quantity) {
            const formData = new FormData();
            formData.append('quantity', quantity);
            formData.append('_token', '{{ csrf_token() }}');
            
            // Find the button and show loading state
            const btn = event.target.closest('button');
            const icon = btn.querySelector('.add-cart-icon');
            const spinner = btn.querySelector('.add-cart-spinner');
            
            if (icon && spinner) {
                icon.classList.add('hidden');
                spinner.classList.remove('hidden');
                btn.disabled = true;
            }
            
            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart badge
                    const badge = document.getElementById('cart-badge');
                    if (data.cartCount > 0) {
                        if (badge) {
                            badge.textContent = data.cartCount;
                        } else {
                            // Create badge if doesn't exist
                            const cartLink = document.querySelector('a[href*="cart"]');
                            const newBadge = document.createElement('span');
                            newBadge.id = 'cart-badge';
                            newBadge.className = 'absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center';
                            newBadge.textContent = data.cartCount;
                            cartLink.appendChild(newBadge);
                        }
                    } else {
                        if (badge) badge.remove();
                    }
                    
                    // Show toast
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred. Please try again.', 'error');
            })
            .finally(() => {
                // Reset button state
                if (icon && spinner) {
                    icon.classList.remove('hidden');
                    spinner.classList.add('hidden');
                    btn.disabled = false;
                }
            });
        }
        
        function addToCartWithQuantity(productId) {
            const quantityInput = document.getElementById('quantity');
            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
            
            const btn = document.getElementById('add-to-cart-btn');
            const icon = btn.querySelector('.add-cart-icon');
            const spinner = btn.querySelector('.add-cart-spinner');
            const btnText = btn.querySelector('.btn-text');
            
            if (icon && spinner) {
                icon.classList.add('hidden');
                spinner.classList.remove('hidden');
                if (btnText) btnText.classList.add('hidden');
                btn.disabled = true;
            }
            
            const formData = new FormData();
            formData.append('quantity', quantity);
            formData.append('_token', '{{ csrf_token() }}');
            
            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const badge = document.getElementById('cart-badge');
                    if (data.cartCount > 0) {
                        if (badge) {
                            badge.textContent = data.cartCount;
                        } else {
                            const cartLink = document.querySelector('a[href*="cart"]');
                            const newBadge = document.createElement('span');
                            newBadge.id = 'cart-badge';
                            newBadge.className = 'absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center';
                            newBadge.textContent = data.cartCount;
                            cartLink.appendChild(newBadge);
                        }
                    }
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred. Please try again.', 'error');
            })
            .finally(() => {
                if (icon && spinner) {
                    icon.classList.remove('hidden');
                    spinner.classList.add('hidden');
                    if (btnText) btnText.classList.remove('hidden');
                    btn.disabled = false;
                }
            });
        }
        
        function showToast(message, type = 'success') {
            const toast = document.getElementById('cart-toast');
            const toastMessage = document.getElementById('cart-toast-message');
            
            toast.className = `fixed bottom-4 right-4 ${type === 'success' ? 'bg-green-600' : 'bg-red-600'} text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-0 opacity-100 transition-all duration-300 z-50`;
            toastMessage.textContent = message;
            
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 2000);
        }
        
        // Quantity controls for product detail page
        function incrementQuantity(max) {
            const input = document.getElementById('quantity');
            if (input) {
                let value = parseInt(input.value);
                if (value < max) {
                    input.value = value + 1;
                }
            }
        }
        
        function decrementQuantity() {
            const input = document.getElementById('quantity');
            if (input) {
                let value = parseInt(input.value);
                if (value > 1) {
                    input.value = value - 1;
                }
            }
        }
    </script>
</body>
</html>
