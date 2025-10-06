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
}
