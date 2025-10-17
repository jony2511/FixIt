@extends('layouts.sidebar')

@section('title', 'Reports & Analytics - Admin Panel')
@section('page-title', 'Reports & Analytics')
@section('page-description', 'View system reports and analytics')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Reports & Analytics</h1>
            <p class="text-gray-600">View system reports and analytics</p>
        </div>
        <div class="flex items-center space-x-4">
            <!-- Date Range Filter -->
            <form method="GET" action="{{ route('admin.reports') }}" class="flex items-center space-x-2">
                <select name="range" onchange="this.form.submit()" class="border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500">
                    <option value="7" {{ $dateRange == '7' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="30" {{ $dateRange == '30' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="90" {{ $dateRange == '90' ? 'selected' : '' }}>Last 90 Days</option>
                    <option value="365" {{ $dateRange == '365' ? 'selected' : '' }}>Last Year</option>
                </select>
            </form>
            
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                ← Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Main Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Requests</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_requests'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Pending</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_requests'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">In Progress</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['in_progress_requests'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Completed</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_requests'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Category Statistics -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Requests by Category</h2>
            
            @if($categoryStats->isNotEmpty())
                <div class="space-y-4">
                    @php $maxCount = $categoryStats->first()->count; @endphp
                    @foreach($categoryStats as $stat)
                    <div class="flex items-center">
                        <div class="w-32 text-sm font-medium text-gray-700 truncate">
                            {{ $stat->category->name ?? 'Uncategorized' }}
                        </div>
                        <div class="flex-1 mx-4">
                            <div class="bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($stat->count / $maxCount) * 100 }}%"></div>
                            </div>
                        </div>
                        <div class="w-16 text-sm text-gray-500 text-right">{{ $stat->count }}</div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    No category data available for the selected period.
                </div>
            @endif
        </div>

        <!-- Performance Metrics -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Performance Metrics</h2>
            
            <div class="space-y-6">
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Average Completion Time</span>
                        <span class="text-sm text-gray-500">{{ $stats['average_completion_time'] }}</span>
                    </div>
                </div>
                
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Completion Rate</span>
                        <span class="text-sm text-gray-500">
                            {{ $stats['total_requests'] > 0 ? round(($stats['completed_requests'] / $stats['total_requests']) * 100, 1) : 0 }}%
                        </span>
                    </div>
                    <div class="bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $stats['total_requests'] > 0 ? ($stats['completed_requests'] / $stats['total_requests']) * 100 : 0 }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">In Progress Rate</span>
                        <span class="text-sm text-gray-500">
                            {{ $stats['total_requests'] > 0 ? round(($stats['in_progress_requests'] / $stats['total_requests']) * 100, 1) : 0 }}%
                        </span>
                    </div>
                    <div class="bg-gray-200 rounded-full h-2">
                        <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $stats['total_requests'] > 0 ? ($stats['in_progress_requests'] / $stats['total_requests']) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Technician Performance -->
    @if($technicianStats->isNotEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Technician Performance</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technician</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completed</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Success Rate</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($technicianStats as $stat)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full" src="{{ $stat->assignedTechnician->avatar_url }}" alt="{{ $stat->assignedTechnician->name }}">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $stat->assignedTechnician->name }}</div>
                                    <div class="text-sm text-gray-500">{{ ucfirst($stat->assignedTechnician->role) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stat->assigned_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stat->completed_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $stat->assigned_count > 0 ? round(($stat->completed_count / $stat->assigned_count) * 100, 1) : 0 }}%
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php $successRate = $stat->assigned_count > 0 ? ($stat->completed_count / $stat->assigned_count) * 100 : 0; @endphp
                            <div class="bg-gray-200 rounded-full h-2 w-24">
                                <div class="bg-{{ $successRate >= 80 ? 'green' : ($successRate >= 60 ? 'yellow' : 'red') }}-500 h-2 rounded-full" style="width: {{ $successRate }}%"></div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Daily Activity Chart -->
    @if($dailyStats->isNotEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Daily Activity (Last {{ $dateRange }} Days)</h2>
        </div>
        
        <div class="p-6">
            <div class="space-y-4">
                @php $maxDaily = $dailyStats->max('total'); @endphp
                @foreach($dailyStats as $daily)
                <div class="flex items-center">
                    <div class="w-24 text-sm font-medium text-gray-700">
                        {{ \Carbon\Carbon::parse($daily->date)->format('M d') }}
                    </div>
                    <div class="flex-1 mx-4">
                        <div class="bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-500 h-3 rounded-full" style="width: {{ $maxDaily > 0 ? ($daily->total / $maxDaily) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="w-20 text-sm text-gray-500 text-right">
                        {{ $daily->total }} total
                    </div>
                    <div class="w-20 text-sm text-green-600 text-right">
                        {{ $daily->completed }} done
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection