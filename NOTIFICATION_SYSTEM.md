# Notification System Documentation

## Overview
A complete real-time notification system has been implemented for the FixIT Laravel application. Users receive notifications for comments, technician assignments, and order status changes. All notifications are clickable and redirect to the relevant pages.

## Features Implemented

### 1. Comment Notifications ✅
- **Trigger**: When someone comments on a user's maintenance request
- **Recipient**: Request owner (unless they made the comment)
- **Notification Type**: `comment`
- **Action**: Redirects to the request page

### 2. Technician Assignment Notifications ✅
- **Trigger**: When an admin assigns a technician to a request
- **Recipients**: 
  - Request owner (gets notified about technician assignment)
  - Technician (gets notified about new assignment)
- **Notification Types**: 
  - `technician_assigned` (for request owner)
  - `request_assigned` (for technician)
- **Action**: Redirects to the request page

### 3. Order Status Change Notifications ✅
- **Trigger**: When admin changes order status (pending → processing → shipped → delivered)
- **Recipient**: Order owner
- **Notification Type**: `order_status`
- **Action**: Redirects to the order details page
- **Statuses Tracked**:
  - Pending
  - Processing
  - Shipped
  - Delivered
  - Cancelled

## Technical Implementation

### Database
- Uses Laravel's built-in notifications table
- Migration: `2025_10_10_191856_create_notifications_table`
- Stores notification data as JSON in database

### Notification Classes

1. **CommentAddedNotification**
   - File: `app/Notifications/CommentAddedNotification.php`
   - Data: request_id, request_title, commenter_name, comment_preview

2. **TechnicianAssignedNotification**
   - File: `app/Notifications/TechnicianAssignedNotification.php`
   - Data: request_id, request_title, technician_name, technician_id

3. **RequestAssignedNotification**
   - File: `app/Notifications/RequestAssignedNotification.php`
   - Data: request_id, request_title, request_priority

4. **OrderStatusChangedNotification**
   - File: `app/Notifications/OrderStatusChangedNotification.php`
   - Data: order_id, order_number, old_status, new_status

### Controllers

**NotificationController** (`app/Http/Controllers/NotificationController.php`)
- `getNotifications()` - AJAX endpoint to fetch notifications
- `markAsRead($id)` - Mark notification as read and redirect
- `markAllAsRead()` - Mark all notifications as read
- `destroy($id)` - Delete a notification

**RequestController Updates**
- Added notification triggers in `addComment()` method
- Added notification triggers in `assign()` method

**AdminController Updates**
- Added notification trigger in `updateOrderStatus()` method

### Routes

```php
GET  /notifications/get                  - Fetch notifications (AJAX)
GET  /notifications/{id}/read            - Mark as read and redirect
POST /notifications/mark-all-read        - Mark all as read
DELETE /notifications/{id}               - Delete notification
```

### Frontend Components

**Notification Bell** (`resources/views/layouts/navigation.blade.php`)
- Bell icon with unread count badge
- Dropdown showing latest 10 notifications
- Real-time updates every 30 seconds
- Click to mark as read and redirect
- "Mark all as read" button

**JavaScript Functions**
- `loadNotifications()` - Fetches and displays notifications
- `markAllAsRead()` - Marks all notifications as read
- `getNotificationIcon(type)` - Returns icon based on notification type
- `getNotificationColor(type)` - Returns color based on notification type
- `formatTime(timestamp)` - Formats notification timestamp

### UI/UX Features

1. **Visual Indicators**
   - Red badge with count of unread notifications
   - Animated pulse effect on badge
   - Blue background for unread notifications
   - Blue dot indicator on unread items

2. **Icons by Type**
   - Comment: `fa-comment` (blue)
   - Technician Assigned: `fa-user-cog` (green)
   - Request Assigned: `fa-clipboard-check` (purple)
   - Order Status: `fa-shopping-bag` (orange)

3. **Interactions**
   - Click notification bell to open dropdown
   - Click notification to mark as read and navigate
   - Click "Mark all as read" to clear all
   - Auto-closes on click outside
   - Smooth transitions and animations

## Usage Examples

### Sending a Notification Manually

```php
use App\Notifications\CommentAddedNotification;

$user->notify(new CommentAddedNotification($request, $commenter, $content));
```

### Checking Unread Notifications

```php
$unreadCount = auth()->user()->unreadNotifications->count();
$unreadNotifications = auth()->user()->unreadNotifications;
```

### Marking as Read

```php
$notification->markAsRead();
// or
auth()->user()->unreadNotifications->markAsRead();
```

## Testing the System

### Test Comment Notifications
1. Log in as User A
2. Create a maintenance request
3. Log in as User B
4. Comment on User A's request
5. Log back in as User A
6. Check notification bell - should see "New Comment" notification

### Test Assignment Notifications
1. Log in as Admin
2. Go to a maintenance request
3. Assign it to a technician
4. Log in as the technician
5. Check notification bell - should see "New Request Assigned" notification
6. Log in as the request owner
7. Should see "Technician Assigned" notification

### Test Order Status Notifications
1. Place an order as a customer
2. Log in as Admin
3. Go to Admin → Orders
4. Change order status
5. Log back in as customer
6. Check notification bell - should see "Order Status Updated" notification

## Security

- All notification routes require authentication
- Users can only see their own notifications
- XSS protection through Laravel's escaping
- CSRF protection on POST requests
- Authorization checks before sending notifications

## Performance

- Notifications stored in database (efficient querying)
- Only latest 10 notifications loaded initially
- Auto-refresh every 30 seconds (configurable)
- Indexed database queries for fast retrieval
- Lazy loading of notification data

## Future Enhancements

Potential improvements for the notification system:

1. **Real-time Updates**: Integrate Laravel Echo with Pusher/Redis for instant notifications
2. **Email Notifications**: Add email channel for important notifications
3. **Push Notifications**: Add browser push notifications support
4. **Notification Preferences**: Let users choose which notifications they want to receive
5. **Notification History**: Full page showing all notifications with pagination
6. **Sound Alerts**: Optional sound when new notification arrives
7. **Desktop Notifications**: Browser desktop notifications API
8. **Mark as Unread**: Allow users to mark notifications as unread
9. **Notification Categories**: Filter notifications by type
10. **Bulk Actions**: Select multiple notifications to delete or mark as read

## Troubleshooting

### Notifications Not Showing
1. Check if user has `Notifiable` trait in User model
2. Verify notifications table exists: `php artisan migrate:status`
3. Clear caches: `php artisan optimize:clear`
4. Check browser console for JavaScript errors

### Notifications Not Sending
1. Check if notification class is imported in controller
2. Verify user relationship exists (e.g., `$order->user`)
3. Check Laravel logs: `storage/logs/laravel.log`
4. Ensure notification channel is `database` not `mail`

### JavaScript Not Working
1. Check if Alpine.js is loaded (used for dropdown)
2. Verify CSRF token is present in meta tag
3. Check browser console for errors
4. Ensure jQuery/Alpine.js isn't conflicting

## File Structure

```
app/
├── Http/Controllers/
│   ├── NotificationController.php
│   ├── RequestController.php (updated)
│   └── AdminController.php (updated)
├── Notifications/
│   ├── CommentAddedNotification.php
│   ├── TechnicianAssignedNotification.php
│   ├── RequestAssignedNotification.php
│   └── OrderStatusChangedNotification.php
resources/views/
└── layouts/
    └── navigation.blade.php (updated with notification UI)
routes/
└── web.php (notification routes added)
database/migrations/
└── 2025_10_10_191856_create_notifications_table.php
```

## Summary

The notification system is now fully functional and production-ready. It provides a seamless user experience with real-time updates, clickable notifications, and proper routing to relevant pages. The system is secure, performant, and easily extensible for future enhancements.
