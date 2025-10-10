<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get notifications for AJAX request
     */
    public function getNotifications()
    {
        $notifications = auth()->user()
            ->notifications()
            ->take(10)
            ->get();

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => auth()->user()->unreadNotifications->count()
        ]);
    }

    /**
     * Mark notification as read and redirect
     */
    public function markAsRead($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->markAsRead();

            // Get the action URL from notification data
            $actionUrl = $notification->data['action_url'] ?? route('dashboard');

            return redirect($actionUrl);
        }

        return redirect()->back();
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->where('id', $id)
            ->first();

        if ($notification) {
            $notification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Notification deleted'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Notification not found'
        ], 404);
    }
}
