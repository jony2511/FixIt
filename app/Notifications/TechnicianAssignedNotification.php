<?php

namespace App\Notifications;

use App\Models\Request as MaintenanceRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TechnicianAssignedNotification extends Notification
{
    use Queueable;

    protected $request;
    protected $technician;

    /**
     * Create a new notification instance.
     */
    public function __construct(MaintenanceRequest $request, User $technician)
    {
        $this->request = $request;
        $this->technician = $technician;
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
            'type' => 'technician_assigned',
            'title' => 'Technician Assigned to Your Request',
            'message' => $this->technician->name . ' has been assigned to your maintenance request',
            'request_id' => $this->request->id,
            'request_title' => $this->request->title,
            'technician_name' => $this->technician->name,
            'technician_id' => $this->technician->id,
            'action_url' => route('requests.show', $this->request->id),
            'icon' => 'user-cog',
        ];
    }
}
