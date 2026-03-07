@extends('layouts.dashboard')

@section('title', 'Sales Reports')
@section('page-title', 'Sales Reports')

@section('content')
<!-- Filter Section -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <form action="{{ route('dashboard.sales') }}" method="GET" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
            <input type="date" name="start_date" value="{{ $startDate }}" 
                   class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
            <input type="date" name="end_date" value="{{ $endDate }}" 
                   class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-indigo-500">
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
            Filter
        </button>
        <a href="{{ route('dashboard.sales') }}" class="text-gray-600 hover:text-gray-800 px-4 py-2">
            Reset
        </a>
    </form>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <p class="text-sm text-gray-500 mb-1">Total Orders</p>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($summary->total_orders ?? 0) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <p class="text-sm text-gray-500 mb-1">Items Sold</p>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($summary->total_items ?? 0) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <p class="text-sm text-gray-500 mb-1">Revenue</p>
        <p class="text-2xl font-bold text-green-600">${{ number_format($summary->total_revenue ?? 0, 2) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <p class="text-sm text-gray-500 mb-1">Cost</p>
        <p class="text-2xl font-bold text-red-600">${{ number_format($summary->total_cost ?? 0, 2) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <p class="text-sm text-gray-500 mb-1">Profit</p>
        <p class="text-2xl font-bold text-indigo-600">${{ number_format($summary->total_profit ?? 0, 2) }}</p>
    </div>
</div>

<!-- Daily Sales Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800">Daily Sales Report</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-500">Date</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-500">Orders</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-500">Items Sold</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-500">Revenue</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-500">Cost</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-500">Profit</th>
                    <th class="text-left py-4 px-6 text-sm font-medium text-gray-500">Margin</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dailySales as $sale)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="py-4 px-6 font-medium text-gray-800">{{ $sale->date->format('M d, Y') }}</td>
                    <td class="py-4 px-6 text-gray-600">{{ number_format($sale->total_orders) }}</td>
                    <td class="py-4 px-6 text-gray-600">{{ number_format($sale->total_items_sold) }}</td>
                    <td class="py-4 px-6 text-green-600 font-medium">${{ number_format($sale->total_revenue, 2) }}</td>
                    <td class="py-4 px-6 text-red-600">${{ number_format($sale->total_cost, 2) }}</td>
                    <td class="py-4 px-6 text-indigo-600 font-medium">${{ number_format($sale->profit, 2) }}</td>
                    <td class="py-4 px-6">
                        @php
                            $margin = $sale->total_revenue > 0 ? ($sale->profit / $sale->total_revenue) * 100 : 0;
                        @endphp
                        <span class="px-2 py-1 rounded text-xs font-medium {{ $margin > 20 ? 'bg-green-100 text-green-800' : ($margin > 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ number_format($margin, 1) }}%
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-12 text-center text-gray-500">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p>No sales data found for the selected period.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($dailySales->hasPages())
    <div class="p-4 border-t border-gray-100">
        {{ $dailySales->links() }}
    </div>
    @endif
</div>
@endsection
