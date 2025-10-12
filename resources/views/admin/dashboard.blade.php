@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-600 mt-2">Manage users, requests, and system settings</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</h3>
                    <p class="text-gray-600">Total Users</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['total_requests'] }}</h3>
                    <p class="text-gray-600">Total Requests</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['pending_requests'] }}</h3>
                    <p class="text-gray-600">Pending</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $stats['completed_requests'] }}</h3>
                    <p class="text-gray-600">Completed</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">User Management</h3>
            <p class="text-gray-600 mb-4">Manage user accounts, roles, and permissions</p>
            <a href="{{ route('admin.users.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                Manage Users
            </a>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Categories</h3>
            <p class="text-gray-600 mb-4">Configure request categories and settings</p>
            <a href="{{ route('admin.categories.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                Manage Categories
            </a>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">
                <i class="fas fa-box mr-2"></i>Products
            </h3>
            <p class="text-gray-600 mb-4">Manage shop products and inventory</p>
            <a href="{{ route('admin.products.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                Manage Products
            </a>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">
                <i class="fas fa-shopping-bag mr-2"></i>Orders
            </h3>
            <p class="text-gray-600 mb-4">View and manage customer orders</p>
            <a href="{{ route('admin.orders') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                View Orders
            </a>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">
                <i class="fas fa-blog mr-2"></i>Blog Management
            </h3>
            <p class="text-gray-600 mb-4">Create and manage blog posts</p>
            <a href="{{ route('admin.blogs.index') }}" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                Manage Blogs
            </a>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Reports</h3>
            <p class="text-gray-600 mb-4">View system reports and analytics</p>
            <a href="{{ route('admin.reports') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                View Reports
            </a>
        </div>
    </div>

    <!-- Recent Requests Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-8">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-medium text-gray-900">Recent Requests</h3>
            <a href="{{ route('requests.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentRequests ?? [] as $request)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($request->title, 40) }}</div>
                                <div class="text-sm text-gray-500">{{ $request->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $request->status_badge_color }}">
                                    {{ $request->status_name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $request->priority_badge_color }}">
                                    {{ $request->priority_name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($request->assignedTechnician)
                                    <div class="flex items-center">
                                        <img class="h-6 w-6 rounded-full mr-2" src="{{ $request->assignedTechnician->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($request->assignedTechnician->name) }}" alt="">
                                        {{ $request->assignedTechnician->name }}
                                    </div>
                                @else
                                    <span class="text-gray-400">Unassigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $request->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('requests.show', $request) }}" 
                                   class="text-blue-600 hover:text-blue-900">View</a>
                                
                                @if(!$request->assignedTechnician)
                                    <button onclick="openAssignModal('{{ $request->id }}')" 
                                            class="text-purple-600 hover:text-purple-900">Assign</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No recent requests found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Assignment Modal -->
<div id="assignModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Assign Request to Technician</h3>
            
            <form id="assignForm" method="POST" action="">
                @csrf
                <div class="mb-4">
                    <label for="technician_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Technician
                    </label>
                    <select name="technician_id" id="technician_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Choose a technician...</option>
                        @foreach($technicians as $technician)
                            <option value="{{ $technician->id }}">
                                {{ $technician->name }} ({{ ucfirst($technician->role) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="closeAssignModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                        Assign Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentRequestId = null;

function openAssignModal(requestId) {
    currentRequestId = requestId;
    const form = document.getElementById('assignForm');
    form.action = `/requests/${requestId}/assign`;
    document.getElementById('assignModal').classList.remove('hidden');
}

function closeAssignModal() {
    document.getElementById('assignModal').classList.add('hidden');
    document.getElementById('technician_id').value = '';
}

// Close modal when clicking outside
document.getElementById('assignModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAssignModal();
    }
});
</script>

@endsection