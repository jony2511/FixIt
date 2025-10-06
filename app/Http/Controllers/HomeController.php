<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as MaintenanceRequest;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Show the public homepage (landing page)
     * Displays recent public requests like a social media feed
     */
    public function index()
    {
        // Get recent public requests with user and category info
        $recentRequests = MaintenanceRequest::with(['user', 'category', 'assignedTechnician'])
            ->public()
            ->latest()
            ->take(10)
            ->get();

        // Get request statistics for homepage
        $stats = [
            'total_requests' => MaintenanceRequest::count(),
            'completed_requests' => MaintenanceRequest::completed()->count(),
            'pending_requests' => MaintenanceRequest::pending()->count(),
            'in_progress_requests' => MaintenanceRequest::inProgress()->count(),
        ];

        return view('home', compact('recentRequests', 'stats'));
    }

    /**
     * Show the authenticated user dashboard (newsfeed)
     * Main page after login - shows personalized request feed
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        // Get requests based on user role
        if ($user->isAdmin()) {
            // Admins see all requests
            $requests = MaintenanceRequest::with(['user', 'category', 'assignedTechnician', 'comments'])
                ->latest()
                ->paginate(15);
        } elseif ($user->isTechnician()) {
            // Technicians see all requests but prioritize assigned ones
            $requests = MaintenanceRequest::with(['user', 'category', 'assignedTechnician', 'comments'])
                ->where(function($query) use ($user) {
                    $query->where('assigned_to', $user->id)
                          ->orWhere('is_public', true);
                })
                ->latest()
                ->paginate(15);
        } else {
            // Regular users see public requests
            $requests = MaintenanceRequest::with(['user', 'category', 'assignedTechnician', 'comments'])
                ->public()
                ->latest()
                ->paginate(15);
        }

        // Get categories for quick filtering
        $categories = Category::active()->orderBy('priority')->get();

        // Get user-specific stats
        $userStats = [
            'my_requests' => $user->requests()->count(),
            'my_pending' => $user->requests()->pending()->count(),
            'my_completed' => $user->requests()->completed()->count(),
        ];

        // Add technician stats if applicable
        if ($user->isTechnician()) {
            $userStats['assigned_to_me'] = $user->assignedRequests()->whereIn('status', ['assigned', 'in_progress'])->count();
            $userStats['completed_by_me'] = $user->assignedRequests()->completed()->count();
        }

        return view('dashboard', compact('requests', 'categories', 'userStats'));
    }
}
