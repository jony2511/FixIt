<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class UpdateOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:update-status {orderId} {status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update order status for testing purposes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderId = $this->argument('orderId');
        $status = $this->argument('status');

        $validStatuses = ['pending', 'processing', 'completed', 'cancelled'];
        
        if (!in_array($status, $validStatuses)) {
            $this->error("Invalid status. Valid statuses are: " . implode(', ', $validStatuses));
            return 1;
        }

        $order = Order::find($orderId);
        
        if (!$order) {
            $this->error("Order with ID {$orderId} not found.");
            return 1;
        }

        $order->update(['status' => $status]);
        
        $this->info("Order #{$orderId} status updated to '{$status}' successfully!");
        
        // Show order details
        $this->table(
            ['Field', 'Value'],
            [
                ['Order ID', $order->id],
                ['Status', $order->status],
                ['Total Amount', '৳' . number_format($order->total_amount, 2)],
                ['Payment Method', $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Payment'],
                ['Transaction ID', $order->transaction_id ?: 'N/A'],
                ['Updated At', $order->updated_at->format('Y-m-d H:i:s')],
            ]
        );

        return 0;
    }
}