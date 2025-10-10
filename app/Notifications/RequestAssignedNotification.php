<?php

namespace App\Notifications;

use App\Models\Request as MaintenanceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class RequestAssignedNotification extends Notification
{
    use Queueable;

    protected $request;

    /**
     * Create a new notification instance.
     */
    public function __construct(MaintenanceRequest $request)
    {
        $this->request = $request;
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
        return [
            'type' => 'request_assigned',
            'title' => 'New Request Assigned to You',
            'message' => 'You have been assigned to work on: ' . $this->request->title,
            'request_id' => $this->request->id,
            'request_title' => $this->request->title,
            'request_priority' => $this->request->priority,
            'action_url' => route('requests.show', $this->request->id),
            'icon' => 'clipboard-check',
        ];
    }
}
