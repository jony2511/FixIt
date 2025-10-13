@extends('layouts.app')

@section('title', 'Contact Messages - Admin Panel')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white">Contact Messages</h1>
                    <p class="text-blue-100">Manage customer inquiries and messages</p>
                </div>
                <div class="flex items-center space-x-4 text-white">
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ $messages->total() }}</div>
                        <div class="text-sm text-blue-100">Total Messages</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold">{{ $messages->where('is_read', false)->count() }}</div>
                        <div class="text-sm text-blue-100">Unread</div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md mx-6 mt-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Messages List -->
        <div class="overflow-x-auto">
            @if($messages->count() > 0)
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                            <th class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Info</th>
                            <th class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($messages as $message)
                            <tr class="hover:bg-gray-50 {{ !$message->is_read ? 'bg-blue-50' : '' }}">
                                <td class="py-4 px-6">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            @if(!$message->is_read)
                                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                            @else
                                                <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $message->full_name }}</p>
                                            <p class="text-sm text-gray-500 line-clamp-2">{{ Str::limit($message->message, 100) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-sm">
                                        <p class="text-gray-900">{{ $message->email }}</p>
                                        @if($message->phone)
                                            <p class="text-gray-500">{{ $message->phone }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-gray-500">
                                    <div>
                                        <p>{{ $message->created_at->format('M d, Y') }}</p>
                                        <p class="text-xs">{{ $message->created_at->format('H:i A') }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($message->is_read)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i> Read
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-envelope mr-1"></i> New
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.contact.show', $message) }}" 
                                           class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                           title="View Message">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <button onclick="toggleRead({{ $message->id }}, {{ $message->is_read ? 'false' : 'true' }})"
                                                class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200"
                                                title="{{ $message->is_read ? 'Mark as Unread' : 'Mark as Read' }}">
                                            <i class="fas fa-{{ $message->is_read ? 'envelope-open' : 'envelope' }}"></i>
                                        </button>
                                        
                                        <form action="{{ route('admin.contact.destroy', $message) }}" 
                                              method="POST" 
                                              class="inline-block"
                                              onsubmit="return confirm('Are you sure you want to delete this message?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                                    title="Delete Message">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No messages yet</h3>
                    <p class="text-gray-500">Contact messages will appear here when submitted.</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($messages->hasPages())
            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>

<script>
async function toggleRead(messageId, isRead) {
    try {
        const response = await fetch(`/admin/contact/${messageId}/toggle-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ is_read: isRead })
        });
        
        if (response.ok) {
            location.reload();
        }
    } catch (error) {
        console.error('Error toggling read status:', error);
    }
}
</script>
@endsection