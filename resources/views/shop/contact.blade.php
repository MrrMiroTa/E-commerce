@extends('layouts.app')

@section('title', 'Contact Us')

@section('styles')
<style>
    .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .contact-card { transition: all 0.3s ease; }
    .contact-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    
    /* Responsive text handling for long content */
    .contact-info-text {
        word-wrap: break-word;
        overflow-wrap: break-word;
        hyphens: auto;
    }
    
    /* Ensure contact info cards handle variable content heights */
    .contact-info-card {
        min-height: auto;
        height: auto;
    }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Contact Us</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Send us a Message</h2>
                    
                    <form method="POST" action="{{ route('shop.contact') }}" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" id="name" name="name" required placeholder="Your name">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" id="email" name="email" required placeholder="your@email.com">
                            </div>
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone (Optional)</label>
                            <input type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" id="phone" name="phone" placeholder="+855 12 345 678">
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" id="subject" name="subject" required>
                                <option value="">Select a subject</option>
                                <option value="order">Order Inquiry</option>
                                <option value="product">Product Question</option>
                                <option value="shipping">Shipping Question</option>
                                <option value="return">Returns & Refunds</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" id="message" name="message" rows="5" required placeholder="How can we help you?"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full gradient-bg text-white font-semibold py-3 px-6 rounded-lg hover:opacity-90 transition transform hover:scale-[1.02]">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="space-y-6">
                <!-- Address -->
                <div class="bg-white rounded-2xl shadow-lg p-6 contact-card contact-info-card">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 gradient-bg rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-semibold text-gray-900">📍 Address</h3>
                            <p class="text-gray-600 mt-1 contact-info-text">
                                Phnom Penh, Cambodia<br>
                                123 Main Street
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="bg-white rounded-2xl shadow-lg p-6 contact-card contact-info-card">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 gradient-bg rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-semibold text-gray-900">📞 Phone</h3>
                            <p class="text-gray-600 mt-1 contact-info-text">
                                +855 12 345 678<br>
                                <span class="text-sm text-gray-500">Mon - Fri: 9AM - 6PM</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="bg-blue-100 rounded-2xl shadow-lg p-6 contact-card contact-info-card">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 gradient-bg rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-semibold text-gray-900">✉️ Email</h3>
                            <p class="text-gray-600 mt-1 contact-info-text">
                                support@example.com<br>
                                sales@example.com
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Live Chat -->
                <div class="bg-white rounded-2xl shadow-lg p-6 contact-card contact-info-card">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 gradient-bg rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-semibold text-gray-900">💬 Live Chat</h3>
                            <p class="text-gray-600 mt-1 contact-info-text">
                                Available 24/7<br>
                                <button type="button" class="mt-2 gradient-bg text-white text-sm font-medium py-2 px-4 rounded-lg hover:opacity-90 transition">
                                    Start Chat
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
