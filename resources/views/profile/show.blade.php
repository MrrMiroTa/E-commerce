@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <!-- Profile Header -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
        <div class="gradient-bg h-28"></div>
        <div class="px-8 pb-8 -mt-12">
            <div class="flex items-end space-x-5">
                <div class="w-24 h-24 rounded-full bg-white border-4 border-white shadow-md flex items-center justify-center">
                    <span class="text-4xl font-bold text-indigo-600">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                </div>
                <div class="pb-2">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                    <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                </div>
                <div class="pb-2 ml-auto">
                    @if($user->isAdmin())
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-800">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Administrator
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Customer
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Account Info Card -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Account Info
                </h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Full Name</p>
                        <p class="text-gray-800 font-medium">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Email</p>
                        <p class="text-gray-800 font-medium">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Role</p>
                        <p class="text-gray-800 font-medium capitalize">{{ $user->role }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Member Since</p>
                        <p class="text-gray-800 font-medium">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                @if($user->isAdmin())
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a href="{{ route('dashboard.index') }}"
                       class="w-full btn-primary text-white py-2 px-4 rounded-lg text-sm font-medium flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Go to Dashboard</span>
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Recent Orders
                </h2>

                @if($orders->isEmpty())
                    <div class="text-center py-10">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <p class="text-gray-400">No orders yet.</p>
                        <a href="{{ route('shop.index') }}" class="text-indigo-600 text-sm font-medium hover:underline mt-2 inline-block">Start Shopping</a>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($orders as $order)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div>
                                <p class="font-medium text-gray-800">#{{ $order->order_number }}</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }} · {{ $order->items->count() }} item(s)</p>
                            </div>
                            <div class="text-right flex flex-col items-end gap-1">
                                <p class="font-semibold text-gray-800">${{ number_format($order->total, 2) }}</p>
                                <span class="inline-block px-2 py-0.5 text-xs rounded-full
                                    @if($order->status === 'completed') bg-green-100 text-green-700
                                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-700
                                    @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                                    @else bg-red-100 text-red-700
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <a href="{{ route('profile.order', $order) }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium transition">
                                    View Details →
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
