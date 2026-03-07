<?php

namespace App\Http\Controllers;

use App\Models\DailySale;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.cart')->with('error', 'Your cart is empty.');
        }

        $cartItems = [];
        $total = 0;
        $unavailableItems = [];

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product && $product->is_active) {
                // Use stored price if available, otherwise fallback to current price
                $price = $details['price'] ?? $product->current_price;
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'price' => $price,
                    'total' => $price * $details['quantity'],
                ];
                $total += $price * $details['quantity'];
            } else {
                // Track unavailable items to notify user
                $unavailableItems[] = $product?->name ?? 'Unknown product';
            }
        }

        // If cart became invalid (all items unavailable), redirect
        if (empty($cartItems)) {
            session()->forget('cart');
            return redirect()->route('shop.cart')->with('error', 'Some items in your cart are no longer available.');
        }

        // Show warning if some items are unavailable
        if (!empty($unavailableItems)) {
            session()->flash('warning', 'Some items are no longer available: ' . implode(', ', $unavailableItems));
        }

        // Shipping based on province: $1 for Phnom Penh, $2.50 for other provinces
        $shipping = 0; // default before province is selected
        $grandTotal = $total + $shipping;

        return view('shop.checkout', compact('cartItems', 'total', 'shipping', 'grandTotal'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('shop.cart')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'province' => 'required|string|max:100|in:Phnom Penh,Siem Reap,Battambang,Banteay Meanchey,Borkong,Kampong Cham,Kampong Chhnang,Kampong Speu,Kampong Thom,Kampot,Kandal,Kep,Koh Kong,Kratié,Mondul Kiri,Oddar Meanchey,Pailin,Pursat,Ratanakiri,Preah Sihanouk,Stung Treng,Svay Rieng,Takeo,Tbong Khmum',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cash,card,bank_transfer',
        ]);

        try {
            DB::transaction(function () use ($request, $cart) {
                $subtotal = 0;
                $items = [];
                $productIds = array_keys($cart);

                // Lock products to prevent race conditions
                $products = Product::whereIn('id', $productIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                // Aggregate quantities per product (handle duplicate products in cart)
                $aggregatedQuantities = [];
                foreach ($cart as $id => $details) {
                    if (!isset($aggregatedQuantities[$id])) {
                        $aggregatedQuantities[$id] = 0;
                    }
                    $aggregatedQuantities[$id] += $details['quantity'];
                }

                // Validate stock and calculate totals using aggregated quantities
                foreach ($aggregatedQuantities as $id => $quantity) {
                    $product = $products->get($id);

                    if (!$product || !$product->is_active) {
                        throw new \Exception('Product not found or inactive.');
                    }

                    if ($product->stock_quantity < $quantity) {
                        throw new \Exception("Not enough stock for {$product->name}. Available: {$product->stock_quantity}, Requested: {$quantity}");
                    }

                    // Use stored price if available, otherwise use current price
                    $price = $cart[$id]['price'] ?? $product->current_price;
                    $itemTotal = $price * $quantity;
                    $subtotal += $itemTotal;

                    $items[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total' => $itemTotal,
                    ];
                }

                // Shipping: $1 for Phnom Penh, $2.50 for other provinces
                $shipping = $request->province === 'Phnom Penh' ? 1.00 : 2.50;
                $tax = 0; // Tax removed
                $total = $subtotal + $shipping;

                // Create order
                $order = Order::create([
                    'order_number' => Order::generateOrderNumber(),
                    'user_id' => auth()->id(),
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'shipping_address' => $request->province . ', ' . $request->shipping_address,
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'shipping_cost' => $shipping,
                    'total' => $total,
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'payment_method' => $request->payment_method,
                    'notes' => $request->notes,
                ]);

                // Create order items and update stock
                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product']->id,
                        'product_name' => $item['product']->name,
                        'unit_price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'total' => $item['total'],
                    ]);

                    $item['product']->decrement('stock_quantity', $item['quantity']);
                }

                // Record daily sale
                DailySale::recordSale($total, count($items));

                // Clear cart
                session()->forget('cart');

                // Store order ID for thank you page
                session()->flash('order_id', $order->id);
            });

            return redirect()->route('shop.thankyou')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            Log::error('Checkout failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'cart' => $cart,
                'request' => $request->except(['_token']),
            ]);
            return back()->with('error', 'An error occurred during checkout. Please try again.')->withInput();
        }
    }

    public function thankyou()
    {
        $orderId = session()->get('order_id');
        $order = null;

        if ($orderId) {
            $order = Order::with('items')->find($orderId);
        }

        return view('shop.thankyou', compact('order'));
    }
}
