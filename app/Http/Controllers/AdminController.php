<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Request as MaintenanceRequest;
use App\Models\Category;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_requests' => MaintenanceRequest::count(),
            'pending_requests' => MaintenanceRequest::where('status', 'pending')->count(),
            'completed_requests' => MaintenanceRequest::where('status', 'completed')->count(),
        ];

        $recentRequests = MaintenanceRequest::with(['user', 'assignedTo', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRequests'));
    }

    /**
     * Show users management
     */
    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    /**
     * Show specific user
     */
    public function showUser(User $user)
    {
        $user->load(['requests', 'assignedRequests']);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Update user role
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,technician,admin'
        ]);

        $user->update(['role' => $request->role]);
        
        return back()->with('success', 'User role updated successfully.');
    }

    /**
     * Toggle user active status
     */
    public function toggleUserActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "User {$status} successfully.");
    }

    /**
     * Show categories management
     */
    public function categories()
    {
        $categories = Category::orderBy('priority')->get();
        return view('admin.categories', compact('categories'));
    }

    /**
     * Show reports
     */
    public function reports()
    {
        return view('admin.reports');
    }
}
