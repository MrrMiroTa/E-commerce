<?php

namespace Database\Seeders;

use App\Models\DailySale;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class SalesDataSeeder extends Seeder
{
    public function run(): void
    {
        // Prevent running in production to avoid data loss
        if (app()->isProduction()) {
            $this->command->warn('SalesDataSeeder cannot be run in production environment.');
            return;
        }

        // Clear existing sales data (delete instead of truncate due to FK constraints)
        OrderItem::query()->delete();
        Order::query()->delete();
        DailySale::query()->delete();

        // Create sample daily sales data for the past 7 days
        $dates = [
            ['date' => now()->subDays(6), 'orders' => 12, 'items' => 18, 'revenue' => 1250.00],
            ['date' => now(), 'orders' => 10, 'items' => 15, 'revenue' => 1150.00],
        ];

        foreach ($dates as $data) {
            $cost = $data['revenue'] * 0.6;
            DailySale::create([
                'date' => $data['date']->format('Y-m-d'),
                'total_orders' => $data['orders'],
                'total_items_sold' => $data['items'],
                'total_revenue' => $data['revenue'],
                'total_cost' => $cost,
                'profit' => $data['revenue'] - $cost,
            ]);
        }

        // Create sample orders
        $orderStatuses = ['pending', 'processing', 'shipped', 'delivered'];
        $paymentMethods = ['cash', 'card', 'bank_transfer'];
        
        for ($i = 0; $i < 15; $i++) {
            $product = Product::inRandomOrder()->first();
            $quantity = rand(1, 3);
            $subtotal = $product->current_price * $quantity;
            $tax = $subtotal * 0.1;
            $shipping = $subtotal > 100 ? 0 : 10;
            $total = $subtotal + $tax + $shipping;

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => 1,
                'customer_name' => 'Customer ' . ($i + 1),
                'customer_email' => 'customer' . ($i + 1) . '@example.com',
                'customer_phone' => '555-01' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'shipping_address' => '123 Main St, City ' . ($i + 1),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping_cost' => $shipping,
                'total' => $total,
                'status' => $orderStatuses[array_rand($orderStatuses)],
                'payment_status' => 'paid',
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'created_at' => now()->subDays(rand(0, 7)),
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_price' => $product->current_price,
                'quantity' => $quantity,
                'total' => $subtotal,
            ]);
        }
    }
}
