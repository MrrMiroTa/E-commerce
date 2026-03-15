<div class="space-y-6">
    <!-- Order Header -->
    <div class="flex justify-between items-start border-b border-gray-200 pb-4">
        <div>
            <p class="text-sm text-gray-500">Order Number</p>
            <p class="text-lg font-bold text-indigo-600">#{{ $order->order_number }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Date</p>
            <p class="font-medium text-gray-800">{{ $order->created_at->format('M d, Y h:i A') }}</p>
        </div>
        <div>
            @php
                $statusColors = [
                    'pending' => 'bg-yellow-100 text-yellow-700',
                    'processing' => 'bg-blue-100 text-blue-700',
                    'shipped' => 'bg-purple-100 text-purple-700',
                    'delivered' => 'bg-green-100 text-green-700',
                    'cancelled' => 'bg-red-100 text-red-700',
                ];
            @endphp
            <p class="text-sm text-gray-500">Status</p>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>
    </div>

    <!-- Customer Info -->
    <div class="grid grid-cols-2 gap-6">
        <div>
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Customer Information</h4>
            <div class="space-y-2">
                <p class="text-gray-800"><span class="font-medium">Name:</span> {{ $order->customer_name }}</p>
                <p class="text-gray-800"><span class="font-medium">Email:</span> {{ $order->customer_email }}</p>
                @if($order->customer_phone)
                <p class="text-gray-800"><span class="font-medium">Phone:</span> {{ $order->customer_phone }}</p>
                @endif
            </div>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Shipping Address</h4>
            <div class="bg-gray-50 rounded-lg p-3">
                <p class="text-gray-800 whitespace-pre-line">{{ $order->shipping_address }}</p>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div>
        <h4 class="text-sm font-semibold text-gray-700 mb-3">Order Items</h4>
        <div class="border border-gray-200 rounded-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600">Product</th>
                        <th class="text-center py-3 px-4 text-xs font-semibold text-gray-600">Qty</th>
                        <th class="text-right py-3 px-4 text-xs font-semibold text-gray-600">Price</th>
                        <th class="text-right py-3 px-4 text-xs font-semibold text-gray-600">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr class="border-t border-gray-200">
                        <td class="py-3 px-4 text-gray-800">{{ $item->product_name }}</td>
                        <td class="py-3 px-4 text-center text-gray-800">{{ $item->quantity }}</td>
                        <td class="py-3 px-4 text-right text-gray-600">${{ number_format($item->unit_price, 2) }}</td>
                        <td class="py-3 px-4 text-right font-medium text-gray-800">${{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="flex justify-end">
        <div class="w-64 space-y-2">
            <div class="flex justify-between text-gray-600">
                <span>Subtotal</span>
                <span>${{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Tax</span>
                <span>${{ number_format($order->tax, 2) }}</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Shipping</span>
                <span>${{ number_format($order->shipping_cost, 2) }}</span>
            </div>
            <div class="flex justify-between text-lg font-bold text-gray-800 pt-2 border-t border-gray-200">
                <span>Total</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Payment Info -->
    <div class="bg-gray-50 rounded-lg p-4">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Payment Method</p>
                <p class="font-medium text-gray-800">{{ ucfirst($order->payment_method ?? 'N/A') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Payment Status</p>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </div>
            @if($order->notes)
            <div class="flex-1 ml-6">
                <p class="text-sm text-gray-500">Notes</p>
                <p class="text-gray-800">{{ $order->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    @if($order->status !== 'cancelled' && $order->status !== 'delivered')
    <div class="flex gap-3 pt-4 border-t border-gray-200">
        <button onclick="closeOrderDetailsModal(); openStatusModal({{ $order->id }}, '{{ $order->order_number }}', '{{ $order->status }}')" 
                class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            Update Status
        </button>
    </div>
    @endif
</div>
