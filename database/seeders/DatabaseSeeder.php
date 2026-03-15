<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user (if not exists)
        // ADMIN_PASSWORD must be set in .env file for security
        $adminPassword = env('ADMIN_PASSWORD');
        
        // In production, require explicit password configuration
        if (!$adminPassword && app()->environment('production')) {
            $this->command->warn('Admin user not created: ADMIN_PASSWORD not set in production environment');
        } elseif ($adminPassword || !app()->environment('production')) {
            // Allow creation in non-production or when password is explicitly provided
            User::firstOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Admin User',
                    'role' => 'admin',
                    'password' => bcrypt($adminPassword ?? 'password'),
                ],
               
            );
            
        }

        // Create categories (idempotent - uses firstOrCreate to avoid duplicates)
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Latest gadgets and devices'],

        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }

        // Create specific user
        User::firstOrCreate(
            ['email' => 'mrruzita@gmail.com'],
            [
                'name' => 'Mrr Uzita',
                'role' => 'user',
                'password' => bcrypt('12345678'),
            ]
        );

        // Create products first (before orders that reference them)
        $products = [
            // Electronics
            [
                'name' => 'Wireless Bluetooth Headphones',
                'description' => 'Premium noise-cancelling wireless headphones with 30-hour battery life.',
                'price' => 149.99,
                'sale_price' => 99.99,
                'stock_quantity' => 50,
                'min_stock_level' => 10,
                'sku' => 'ELEC-001',
                'category_id' => 1,
                'is_featured' => true,
            ],
            [
                'name' => 'Smart Watch Pro',
                'description' => 'Advanced fitness tracking and health monitoring smartwatch.',
                'price' => 299.99,
                'stock_quantity' => 30,
                'min_stock_level' => 5,
                'sku' => 'ELEC-002',
                'category_id' => 1,
                'is_featured' => true,
            ],
            [
                'name' => '4K Ultra HD Webcam',
                'description' => 'Professional streaming webcam with auto-focus and noise reduction.',
                'price' => 129.99,
                'sale_price' => 89.99,
                'stock_quantity' => 25,
                'min_stock_level' => 8,
                'sku' => 'ELEC-003',
                'category_id' => 1,
            ],
            [
                'name' => 'Portable Power Bank 20000mAh',
                'description' => 'High-capacity power bank with fast charging support.',
                'price' => 49.99,
                'stock_quantity' => 100,
                'min_stock_level' => 20,
                'sku' => 'ELEC-004',
                'category_id' => 1,
            ],
            // Clothing
           
        ];

        foreach ($products as $product) {
            Product::create(array_merge($product, [
                'slug' => Str::slug($product['name']),
                'is_active' => true,
            ]));
        }

        // Create sample daily sales data for the past 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $orders = rand(5, 25);
            $items = $orders * rand(1, 3);
            $revenue = $orders * rand(50, 200);
            $cost = $revenue * 0.6;
            $profit = $revenue - $cost;

            \App\Models\DailySale::create([
                'date' => $date->format('Y-m-d'),
                'total_orders' => $orders,
                'total_items_sold' => $items,
                'total_revenue' => $revenue,
                'total_cost' => $cost,
                'profit' => $profit,
            ]);
        }

        // Create sample orders (after products exist)
        $orderStatuses = ['pending', 'processing', 'shipped', 'delivered'];
        for ($i = 0; $i < 10; $i++) {
            $product = Product::inRandomOrder()->first();
            
            // Skip if no products exist
            if (!$product) {
                continue;
            }
            
            $order = \App\Models\Order::create([
                'order_number' => \App\Models\Order::generateOrderNumber(),
                'user_id' => 1,
                'customer_name' => 'Customer ' . ($i + 1),
                'customer_email' => 'customer' . ($i + 1) . '@example.com',
                'customer_phone' => '555-01' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'shipping_address' => '123 Main St, City ' . ($i + 1),
                'subtotal' => $product->current_price,
                'tax' => $product->current_price * 0.1,
                'shipping_cost' => 10,
                'total' => $product->current_price * 1.1 + 10,
                'status' => $orderStatuses[array_rand($orderStatuses)],
                'payment_status' => 'paid',
                'payment_method' => 'cash',
                'created_at' => now(),
            ]);

            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'unit_price' => $product->current_price,
                'quantity' => 1,
                'total' => $product->current_price,
            ]);
        }
    }
}
