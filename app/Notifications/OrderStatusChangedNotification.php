<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStatusChangedNotification extends Notification
{
    use Queueable;

    protected $order;
    protected $oldStatus;
    protected $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, string $oldStatus, string $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $statusMessages = [
            'pending' => 'Your order is pending confirmation',
            'processing' => 'Your order is being prepared',
            'shipped' => 'Your order has been shipped',
            'delivered' => 'Your order has been delivered',
            'cancelled' => 'Your order has been cancelled',
        ];

        $statusIcons = [
            'pending' => 'clock',
            'processing' => 'box',
            'shipped' => 'truck',
            'delivered' => 'check-circle',
            'cancelled' => 'times-circle',
        ];

        return [
            'type' => 'order_status',
            'title' => 'Order Status Updated',
            'message' => 'Order #' . $this->order->order_number . ' status changed to: ' . ucfirst($this->newStatus),
            'description' => $statusMessages[$this->newStatus] ?? 'Your order status has been updated.',
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'action_url' => route('user.orders.show', $this->order->id),
            'icon' => $statusIcons[$this->newStatus] ?? 'shopping-bag',
        ];
    }
}
