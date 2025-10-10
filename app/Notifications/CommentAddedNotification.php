<?php

namespace App\Notifications;

use App\Models\Request as MaintenanceRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CommentAddedNotification extends Notification
{
    use Queueable;

    protected $request;
    protected $commenter;
    protected $commentContent;

    /**
     * Create a new notification instance.
     */
    public function __construct(MaintenanceRequest $request, User $commenter, string $commentContent)
    {
        $this->request = $request;
        $this->commenter = $commenter;
        $this->commentContent = $commentContent;
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
            'type' => 'comment',
            'title' => 'New Comment on Your Request',
            'message' => $this->commenter->name . ' commented on your maintenance request',
            'comment_preview' => substr($this->commentContent, 0, 100),
            'request_id' => $this->request->id,
            'request_title' => $this->request->title,
            'commenter_name' => $this->commenter->name,
            'commenter_id' => $this->commenter->id,
            'action_url' => route('requests.show', $this->request->id),
            'icon' => 'comment',
        ];
    }
}
