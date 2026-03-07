<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();
        $orders = $user->orders()->with('items.product')->latest()->take(5)->get();

        return view('profile.show', compact('user', 'orders'));
    }

    public function showOrder(Order $order)
    {
        // Require authentication to view order details
        // For guest checkouts (user_id = null), require session verification or authentication
        if (Auth::guest()) {
            abort(403, 'Please log in to view your order.');
        }
        
        // Verify the order belongs to the authenticated user
        if ($order->user_id !== null && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        $order->load('items');

        return view('shop.order-detail', compact('order'));
    }
}
