@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Checkout</h1>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Checkout Form -->
        <div class="flex-1">
            <form id="checkout-form" action="{{ route('shop.checkout.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                
                <!-- Contact Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
                        Contact Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <input type="text" name="customer_name" id="customer_name" required 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                                   value="{{ old('customer_name') }}">
                            @error('customer_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                            <input type="email" name="customer_email" id="customer_email" required 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                                   value="{{ old('customer_email') }}">
                            @error('customer_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" name="customer_phone" id="customer_phone" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                                   value="{{ old('customer_phone') }}">
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
                        Shipping Address
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <label for="province" class="block text-sm font-medium text-gray-700 mb-1">Province / City *</label>
                            <select name="province" id="province" required onchange="updateShipping(this.value)"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                                <option value="">-- Select Province --</option>
                                <option value="Phnom Penh" {{ old('province') == 'Phnom Penh' ? 'selected' : '' }}>Phnom Penh ($1.00 shipping)</option>
                                <option value="Siem Reap" {{ old('province') == 'Siem Reap' ? 'selected' : '' }}>Siem Reap ($2.50 shipping)</option>
                                <option value="Battambang" {{ old('province') == 'Battambang' ? 'selected' : '' }}>Battambang ($2.50 shipping)</option>
                                <option value="Kampong Cham" {{ old('province') == 'Kampong Cham' ? 'selected' : '' }}>Kampong Cham ($2.50 shipping)</option>
                                <option value="Kampong Chhnang" {{ old('province') == 'Kampong Chhnang' ? 'selected' : '' }}>Kampong Chhnang ($2.50 shipping)</option>
                                <option value="Kampong Speu" {{ old('province') == 'Kampong Speu' ? 'selected' : '' }}>Kampong Speu ($2.50 shipping)</option>
                                <option value="Kampong Thom" {{ old('province') == 'Kampong Thom' ? 'selected' : '' }}>Kampong Thom ($2.50 shipping)</option>
                                <option value="Kampot" {{ old('province') == 'Kampot' ? 'selected' : '' }}>Kampot ($2.50 shipping)</option>
                                <option value="Kandal" {{ old('province') == 'Kandal' ? 'selected' : '' }}>Kandal ($2.50 shipping)</option>
                                <option value="Kep" {{ old('province') == 'Kep' ? 'selected' : '' }}>Kep ($2.50 shipping)</option>
                                <option value="Koh Kong" {{ old('province') == 'Koh Kong' ? 'selected' : '' }}>Koh Kong ($2.50 shipping)</option>
                                <option value="Kratie" {{ old('province') == 'Kratie' ? 'selected' : '' }}>Kratie ($2.50 shipping)</option>
                                <option value="Mondulkiri" {{ old('province') == 'Mondulkiri' ? 'selected' : '' }}>Mondulkiri ($2.50 shipping)</option>
                                <option value="Oddar Meanchey" {{ old('province') == 'Oddar Meanchey' ? 'selected' : '' }}>Oddar Meanchey ($2.50 shipping)</option>
                                <option value="Pailin" {{ old('province') == 'Pailin' ? 'selected' : '' }}>Pailin ($2.50 shipping)</option>
                                <option value="Preah Sihanouk" {{ old('province') == 'Preah Sihanouk' ? 'selected' : '' }}>Preah Sihanouk ($2.50 shipping)</option>
                                <option value="Preah Vihear" {{ old('province') == 'Preah Vihear' ? 'selected' : '' }}>Preah Vihear ($2.50 shipping)</option>
                                <option value="Prey Veng" {{ old('province') == 'Prey Veng' ? 'selected' : '' }}>Prey Veng ($2.50 shipping)</option>
                                <option value="Pursat" {{ old('province') == 'Pursat' ? 'selected' : '' }}>Pursat ($2.50 shipping)</option>
                                <option value="Ratanakiri" {{ old('province') == 'Ratanakiri' ? 'selected' : '' }}>Ratanakiri ($2.50 shipping)</option>
                                <option value="Stung Treng" {{ old('province') == 'Stung Treng' ? 'selected' : '' }}>Stung Treng ($2.50 shipping)</option>
                                <option value="Svay Rieng" {{ old('province') == 'Svay Rieng' ? 'selected' : '' }}>Svay Rieng ($2.50 shipping)</option>
                                <option value="Takeo" {{ old('province') == 'Takeo' ? 'selected' : '' }}>Takeo ($2.50 shipping)</option>
                                <option value="Tboung Khmum" {{ old('province') == 'Tboung Khmum' ? 'selected' : '' }}>Tboung Khmum ($2.50 shipping)</option>
                            </select>
                            @error('province')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Street Address *</label>
                            <textarea name="shipping_address" id="shipping_address" rows="3" required
                                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <span class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-sm font-bold mr-3">3</span>
                        Payment Method
                    </h2>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-indigo-500 transition">
                            <input type="radio" name="payment_method" value="cash" {{ old('payment_method', 'cash') == 'cash' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-3 flex-1">
                                <span class="font-medium text-gray-800">Cash on Delivery</span>
                                <p class="text-sm text-gray-500">Pay when you receive your order</p>
                            </span>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-indigo-500 transition">
                            <input type="radio" name="payment_method" value="card" {{ old('payment_method') == 'card' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-3 flex-1">
                                <span class="font-medium text-gray-800">Credit Card</span>
                                <p class="text-sm text-gray-500">Pay securely with your credit card (PayPal)</p>
                            </span>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-indigo-500 transition">
                            <input type="radio" name="payment_method" value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-3 flex-1">
                                <span class="font-medium text-gray-800">Bank Transfer</span>
                                <p class="text-sm text-gray-500">Transfer directly to our bank account</p>
                            </span>
                        </label>
                    </div>
                    @error('payment_method')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror

                    <!-- Cash on Delivery Info -->
                    <div id="payment-cash" class="payment-form mt-4 p-4 bg-green-50 rounded-lg border border-green-200" style="display: block;">
                        <p class="text-green-700">You will pay <strong>${{ number_format($grandTotal, 2) }}</strong> when your order is delivered to your address.</p>
                    </div>

                    <!-- Credit Card Form (PayPal Sandbox) -->
                    <div id="payment-card" class="payment-form mt-4" style="display: none;">
                        <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <p class="text-blue-700 mb-4">Pay securely using PayPal Sandbox. You will be redirected to PayPal to complete payment.</p>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                                    <input type="text" name="card_number" placeholder="1234 5678 9012 3456" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500"
                                           maxlength="19">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                        <input type="text" name="card_expiry" placeholder="MM/YY" 
                                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500"
                                               maxlength="5">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                        <input type="text" name="card_cvv" placeholder="123" 
                                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500"
                                               maxlength="4">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Cardholder Name</label>
                                    <input type="text" name="card_name" placeholder="John Doe" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500">
                                </div>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="text-xs text-gray-500">Secure payment powered by PayPal Sandbox</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Transfer Form -->
                    <div id="payment-bank_transfer" class="payment-form mt-4" style="display: none;">
                        <div class="p-4 bg-purple-50 rounded-lg border border-purple-200">
                            <p class="text-purple-700 mb-4">Transfer the total amount to one of our bank accounts below and upload the payment proof.</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <div class="flex items-center gap-2 mb-2">
                                        <img src="https://yt3.googleusercontent.com/ytc/AIdro_ljV-vXKHv8x9yHY_Z6RuI9jutIh6f8D0O1oYIY43fJiNo=s900-c-k-c0x00ffffff-no-rj" alt="ABA Bank Logo" class="w-10 h-10 rounded-lg object-cover">
                                        <span class="font-semibold text-gray-800">ABA Bank</span>
                                    </div>
                                    <p class="text-sm text-gray-600">Account Name: DOEUN SOPHORS</p>
                                    <p class="text-sm text-gray-600">Account Number: 004 279 332</p>
                                    <div class="mt-2 p-2 bg-white border border-gray-200 rounded-lg inline-block">
                                        <img src="{{ asset('aba.jpg') }}" alt="ABA QR Code" class="w-32 h-32">
                                    </div>
                                </div>
                                <div class="bg-white p-4 rounded-lg border border-gray-200">
                                    <div class="flex items-center gap-2 mb-2">
                                        <img src="https://play-lh.googleusercontent.com/weU8O2dHEQffcEyHeK11qTUMS-AQvlHW1IolQDM1XLuZN0ggl6Zr9kUwBqHwXr7i5T0" alt="Aceleda Bank Logo" class="w-10 h-10 rounded-lg object-cover">
                                        <span class="font-semibold text-gray-800">Aceleda Bank</span>
                                    </div>
                                    <p class="text-sm text-gray-600">Account Name: DEOUN SOPHORS</p>
                                    <p class="text-sm text-gray-600">Account Number: 099 390 353</p>
                                    <div class="mt-2 p-2 bg-white border border-gray-200 rounded-lg inline-block">
                                        <img src="{{ asset('aceleda.jpg') }}" alt="Aceleda QR Code" class="w-32 h-32">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Payment Proof (Screenshot/Photo)</label>
                                <input type="file" name="payment_proof" accept="image/*" 
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500">
                                <p class="text-xs text-gray-500 mt-1">Please upload a screenshot or photo of your transfer receipt</p>
                            </div>
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Transfer Reference (Optional)</label>
                                <input type="text" name="transfer_reference" placeholder="Transaction ID from bank app" 
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Error Message Box -->
                <div id="payment-error" class="hidden bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p id="payment-error-message" class="text-red-700"></p>
                            <button type="button" onclick="document.getElementById('payment-error').classList.add('hidden')" class="mt-2 text-sm text-red-600 hover:text-red-800 font-medium">
                                Continue filling form
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Additional Notes (Optional)</h2>
                    <textarea name="notes" rows="3" placeholder="Special instructions for delivery..."
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">{{ old('notes') }}</textarea>
                </div>

                <!-- Submit Button (Mobile) -->
                <div class="lg:hidden">
                    <button type="submit" class="w-full btn-primary text-white font-semibold py-4 rounded-lg hover:opacity-90 transition">
                        Place Order - <span id="mobile-total">${{ number_format($grandTotal, 2) }}</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="w-full lg:w-96">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Order Summary</h2>
                
                <!-- Cart Items -->
                <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
                    @foreach($cartItems as $item)
                    <div class="flex items-center gap-3">
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                            @if($item['product']->image)
                                <img src="{{ $item['product']->image }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800 truncate">{{ $item['product']->name }}</p>
                            <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                        </div>
                        <p class="font-medium text-gray-800">${{ number_format($item['total'], 2) }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="border-t pt-4 space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping</span>
                        <span id="shipping-display">${{ number_format($shipping, 2) }}</span>
                    </div>
                </div>

                <div class="border-t pt-4 mt-4">
                    <div class="flex justify-between text-xl font-bold text-gray-800">
                        <span>Total</span>
                        <span id="grand-total-display">${{ number_format($grandTotal, 2) }}</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1" id="shipping-note">Select your province to see shipping cost.</p>
                </div>

                <!-- Submit Button (Desktop) -->
                <button type="submit" form="checkout-form" class="hidden lg:block w-full btn-primary text-white font-semibold py-4 rounded-lg hover:opacity-90 transition mt-6">
                    Place Order
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const subtotal = {{ $total }};

    function updateShipping(province) {
        let shipping = 0;
        let note = '';

        if (province === 'Phnom Penh') {
            shipping = 1.00;
            note = 'Shipping to Phnom Penh: $1.00';
        } else if (province !== '') {
            shipping = 2.50;
            note = 'Shipping to other province: $2.50';
        } else {
            note = 'Select your province to see shipping cost.';
        }

        const grandTotal = subtotal + shipping;

        document.getElementById('shipping-display').textContent = province ? '$' + shipping.toFixed(2) : '$0.00';
        document.getElementById('grand-total-display').textContent = '$' + grandTotal.toFixed(2);
        document.getElementById('mobile-total').textContent = '$' + grandTotal.toFixed(2);
        document.getElementById('shipping-note').textContent = note;
        
        const cashMsg = document.querySelector('#payment-cash p');
        if (cashMsg) {
            cashMsg.innerHTML = 'You will pay <strong>$' + grandTotal.toFixed(2) + '</strong> when your order is delivered to your address.';
        }
    }

    function togglePaymentForm(method) {
        var forms = document.getElementsByClassName('payment-form');
        for (var i = 0; i < forms.length; i++) {
            forms[i].style.display = 'none';
        }
        
        var selectedForm = document.getElementById('payment-' + method);
        if (selectedForm) {
            selectedForm.style.display = 'block';
        }
    }

    window.onload = function() {
        var radios = document.getElementsByName('payment_method');
        for (var i = 0; i < radios.length; i++) {
            radios[i].addEventListener('change', function() {
                togglePaymentForm(this.value);
            });
            if (radios[i].checked) {
                togglePaymentForm(radios[i].value);
            }
        }
        
        var provinceSelect = document.getElementById('province');
        if (provinceSelect && provinceSelect.value) {
            updateShipping(provinceSelect.value);
        }
        
        // Form validation on submit
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            var paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
            var errorBox = document.getElementById('payment-error');
            var errorMessage = document.getElementById('payment-error-message');
            
            if (paymentMethod === 'card') {
                var cardNumber = document.querySelector('input[name="card_number"]').value;
                var cardExpiry = document.querySelector('input[name="card_expiry"]').value;
                var cardCvv = document.querySelector('input[name="card_cvv"]').value;
                var cardName = document.querySelector('input[name="card_name"]').value;
                
                if (!cardNumber || !cardExpiry || !cardCvv || !cardName) {
                    errorMessage.textContent = 'Please fill in all card details to complete your order.';
                    errorBox.classList.remove('hidden');
                    e.preventDefault();
                    return false;
                }
            }
            
            if (paymentMethod === 'bank_transfer') {
                var paymentProof = document.querySelector('input[name="payment_proof"]').value;
                
                if (!paymentProof) {
                    errorMessage.textContent = 'Please upload payment proof for bank transfer to complete your order.';
                    errorBox.classList.remove('hidden');
                    e.preventDefault();
                    return false;
                }
            }
        });
    };
</script>
@endsection
