<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Request as MaintenanceRequest;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        try {
            $stats = [
                'total_users' => User::count(),
                'total_requests' => MaintenanceRequest::count(),
                'pending_requests' => MaintenanceRequest::where('status', 'pending')->count(),
                'completed_requests' => MaintenanceRequest::where('status', 'completed')->count(),
            ];

            $recentRequests = MaintenanceRequest::with(['user', 'assignedTechnician', 'category'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            $technicians = User::where('role', 'technician')
                ->orWhere('role', 'admin')
                ->orderBy('name')
                ->get(['id', 'name', 'role']);

            return view('admin.dashboard', compact('stats', 'recentRequests', 'technicians'));

        } catch (\Exception $e) {
            Log::error('Admin dashboard error: ' . $e->getMessage());

            $stats = [
                'total_users' => 0,
                'total_requests' => 0,
                'pending_requests' => 0,
                'completed_requests' => 0,
            ];
            $recentRequests = collect([]);
            $technicians = collect([]);

            return view('admin.dashboard', compact('stats', 'recentRequests', 'technicians'))
                ->with('error', 'Some data could not be loaded. Please refresh the page.');
        }
    }

    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function showUser(User $user)
    {
        $userRequests = MaintenanceRequest::where('user_id', $user->id)
            ->with(['category', 'assignedTechnician'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.show', compact('user', 'userRequests'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,technician,admin'
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'User role updated successfully!');
    }

    public function toggleUserActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "User has been {$status} successfully!");
    }

    public function categories()
    {
        try {
            $categories = \App\Models\Category::withCount('requests')
                ->orderBy('name')
                ->get();

            $stats = [
                'total_categories' => $categories->count(),
                'most_used' => $categories->sortByDesc('requests_count')->first(),
                'least_used' => $categories->sortBy('requests_count')->first(),
            ];

            return view('admin.categories', compact('categories', 'stats'));
        } catch (\Exception $e) {
            Log::error('Admin categories error: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', 'Unable to load categories. Please try again.');
        }
    }

    public function reports()
    {
        try {
            $dateRange = request('range', '30'); // Default 30 days
            $startDate = now()->subDays((int)$dateRange);
            
            $stats = [
                'total_requests' => MaintenanceRequest::where('created_at', '>=', $startDate)->count(),
                'pending_requests' => MaintenanceRequest::where('created_at', '>=', $startDate)
                    ->where('status', 'pending')->count(),
                'in_progress_requests' => MaintenanceRequest::where('created_at', '>=', $startDate)
                    ->where('status', 'in_progress')->count(),
                'completed_requests' => MaintenanceRequest::where('created_at', '>=', $startDate)
                    ->where('status', 'completed')->count(),
                'average_completion_time' => $this->getAverageCompletionTime($startDate),
            ];

            $categoryStats = MaintenanceRequest::selectRaw('category_id, COUNT(*) as count')
                ->with('category')
                ->where('created_at', '>=', $startDate)
                ->groupBy('category_id')
                ->orderByDesc('count')
                ->get();

            $technicianStats = MaintenanceRequest::selectRaw('assigned_to, COUNT(*) as assigned_count, 
                    SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_count')
                ->with('assignedTechnician')
                ->where('created_at', '>=', $startDate)
                ->whereNotNull('assigned_to')
                ->groupBy('assigned_to')
                ->orderByDesc('assigned_count')
                ->get();

            $dailyStats = MaintenanceRequest::selectRaw('DATE(created_at) as date, 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed')
                ->where('created_at', '>=', $startDate)
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            return view('admin.reports', compact('stats', 'categoryStats', 'technicianStats', 'dailyStats', 'dateRange'));
            
        } catch (\Exception $e) {
            Log::error('Admin reports error: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', 'Unable to load reports. Please try again.');
        }
    }

    private function getAverageCompletionTime($startDate)
    {
        $completedRequests = MaintenanceRequest::where('created_at', '>=', $startDate)
            ->where('status', 'completed')
            ->whereNotNull('completed_at')
            ->get(['created_at', 'completed_at']);

        if ($completedRequests->isEmpty()) {
            return 'N/A';
        }

        $totalHours = 0;
        foreach ($completedRequests as $request) {
            $totalHours += $request->created_at->diffInHours($request->completed_at);
        }

        $averageHours = $totalHours / $completedRequests->count();
        
        if ($averageHours < 24) {
            return round($averageHours, 1) . ' hours';
        } else {
            return round($averageHours / 24, 1) . ' days';
        }
    }
}
