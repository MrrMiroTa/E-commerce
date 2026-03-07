<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $cartItems = [];

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
            }
        }

        return view('shop.cart', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if (!$product->is_in_stock) {
            $message = 'Product is out of stock.';
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $message], 400);
            }
            return back()->with('error', $message);
        }

        if ($request->quantity > $product->stock_quantity) {
            $message = 'Not enough stock available.';
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $message], 400);
            }
            return back()->with('error', $message);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $request->quantity;
            if ($newQuantity > $product->stock_quantity) {
                $message = 'Not enough stock available.';
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => $message], 400);
                }
                return back()->with('error', $message);
            }
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            $cart[$product->id] = [
                'quantity' => $request->quantity,
                'price' => $product->current_price, // Store price at add time
            ];
        }

        session()->put('cart', $cart);
        
        $cartCount = array_sum(array_column($cart, 'quantity'));
        $message = 'Product added to cart successfully!';
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => $message,
                'cartCount' => $cartCount
            ]);
        }
        
        return back()->with('success', $message);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($request->quantity > $product->stock_quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated successfully!');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Product removed from cart!');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared successfully!');
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));
        return response()->json(['count' => $count]);
    }
}
