<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class TestOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first user
        $user = User::first();
        
        if (!$user) {
            $this->command->error('No users found. Please create a user first.');
            return;
        }

        // Generate order number
        $orderNumber = 'ORD-' . str_pad(time() % 100000, 5, '0', STR_PAD_LEFT);
        
        // Create a completed test order
        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => $user->id,
            'shipping_name' => $user->name,
            'shipping_address' => '123 Test Street, Gulshan',
            'shipping_city' => 'Dhaka',
            'shipping_postal_code' => '1212',
            'shipping_phone' => '+8801234567890',
            'shipping_email' => $user->email,
            'payment_method' => 'online',
            'total_amount' => 1550.00,
            'order_status' => 'pending',
            'payment_status' => 'pending',
            'transaction_id' => 'TXN_TEST_' . time(),
            'notes' => 'Test order for PDF invoice functionality',
            'payment_details' => json_encode([
                'gateway' => 'SSLCommerz',
                'payment_date' => now()->toDateTimeString()
            ])
        ]);

        // Add order items
        $products = Product::take(2)->get();
        
        foreach ($products as $index => $product) {
            $quantity = $index + 1;
            $price = $index === 0 ? 750.00 : 550.00;
            $subtotal = $quantity * $price;
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $subtotal,
            ]);
        }

        $this->command->info("Test order created with ID: {$order->id}");
        $this->command->info("Order total: ৳{$order->total_amount}");
        $this->command->info("Transaction ID: {$order->transaction_id}");
        $this->command->info("You can now test PDF invoice generation!");
    }
}