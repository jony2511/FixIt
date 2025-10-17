@extends('layouts.sidebar')

@section('title', 'Assigned Requests')
@section('page-title', 'Assigned Requests')
@section('page-description', 'Requests assigned to you for resolution')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Assigned Requests</h1>
        <p class="text-gray-600 mt-2">Requests assigned to you for resolution</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 text-center">
            <div class="text-3xl font-bold text-orange-600 mb-2">{{ $requests->where('status', 'assigned')->count() }}</div>
            <div class="text-gray-600">Assigned</div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 text-center">
            <div class="text-3xl font-bold text-blue-600 mb-2">{{ $requests->where('status', 'in_progress')->count() }}</div>
            <div class="text-gray-600">In Progress</div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 text-center">
            <div class="text-3xl font-bold text-green-600 mb-2">{{ auth()->user()->assignedRequests()->completed()->count() }}</div>
            <div class="text-gray-600">Completed Total</div>
        </div>
    </div>

    <!-- Requests List -->
    @forelse($requests as $request)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden hover:shadow-md transition duration-200">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-3">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $request->title }}</h3>
                            <span class="ml-3 px-3 py-1 text-sm font-medium rounded-full {{ $request->status_badge_color }}">
                                {{ $request->status_name }}
                            </span>
                            <span class="ml-2 px-3 py-1 text-sm font-medium rounded-full {{ $request->priority_badge_color }}">
                                {{ $request->priority_name }}
                            </span>
                        </div>
                        
                        <p class="text-gray-600 mb-4">{{ Str::limit($request->description, 200) }}</p>
                        
                        <!-- Request Meta -->
                        <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
                            <span class="flex items-center">
                                <img class="h-6 w-6 rounded-full mr-2" src="{{ $request->user->avatar_url }}" alt="{{ $request->user->name }}">
                                {{ $request->user->name }}
                            </span>
                            
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                                {{ $request->location }}
                            </span>
                            
                            @if($request->category)
                                <span class="px-2 py-1 text-xs rounded-full" 
                                      style="background-color: {{ $request->category->color }}20; color: {{ $request->category->color }};">
                                    {{ $request->category->name }}
                                </span>
                            @endif
                            
                            <span>{{ $request->created_at->diffForHumans() }}</span>
                            
                            @if($request->assigned_at)
                                <span>Assigned {{ $request->assigned_at->diffForHumans() }}</span>
                            @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-3">
                            @if($request->canBeStarted())
                                <form method="POST" action="{{ route('requests.start', $request) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition duration-200">
                                        Start Work
                                    </button>
                                </form>
                            @endif
                            
                            @if($request->canBeCompleted())
                                <button type="button" 
                                        onclick="openCompleteModal('{{ $request->id }}')"
                                        class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition duration-200">
                                    Mark Complete
                                </button>
                            @endif
                            
                            <a href="{{ route('requests.show', $request) }}" 
                               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No assigned requests</h3>
            <p class="text-gray-500">No requests have been assigned to you yet.</p>
        </div>
    @endforelse
    
    <!-- Pagination -->
    @if($requests->hasPages())
        <div class="mt-6">
            {{ $requests->links() }}
        </div>
    @endif
</div>

<!-- Complete Request Modal -->
<div id="completeModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Complete Request</h3>
            
            <form id="completeForm" method="POST" action="">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Completion Notes</label>
                    <textarea name="completion_notes" 
                              rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                              placeholder="Describe what was done to resolve the issue..."></textarea>
                </div>
                
                <div class="flex items-center space-x-3">
                    <button type="button" 
                            onclick="closeCompleteModal()"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg">
                        Complete Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openCompleteModal(requestId) {
    const modal = document.getElementById('completeModal');
    const form = document.getElementById('completeForm');
    form.action = `/requests/${requestId}/complete`;
    modal.classList.remove('hidden');
}

function closeCompleteModal() {
    document.getElementById('completeModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('completeModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCompleteModal();
    }
});
</script>
@endsection