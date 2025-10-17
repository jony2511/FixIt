@extends('layouts.sidebar')

@section('title', 'View Contact Message - Admin Panel')
@section('page-title', 'Contact Message Details')
@section('page-description', 'View and manage customer inquiry')

@section('content')
<div class="container mx-auto">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.contact.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Messages
            </a>
        </div>

        <!-- Message Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Contact Message</h1>
                        <p class="text-blue-100">{{ $contact->created_at->format('M d, Y \a\t H:i A') }}</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($contact->is_read)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i> Read
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-envelope mr-1"></i> New
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Contact Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $contact->full_name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                            <p class="text-gray-900">
                                <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $contact->email }}
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        @if($contact->phone)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                                <p class="text-gray-900">
                                    <a href="tel:{{ $contact->phone }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $contact->phone }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Received</label>
                            <p class="text-gray-900">{{ $contact->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Message -->
                <div class="border-t border-gray-200 pt-6">
                    <label class="block text-sm font-medium text-gray-500 mb-3">Message</label>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-900 leading-relaxed whitespace-pre-wrap">{{ $contact->message }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Reply Button -->
                            <a href="mailto:{{ $contact->email }}?subject=Re: Your inquiry&body=Hi {{ $contact->full_name }},%0D%0A%0D%0AThank you for contacting us..." 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                <i class="fas fa-reply mr-2"></i>
                                Reply via Email
                            </a>
                            
                            <!-- Toggle Read Status -->
                            <button onclick="toggleRead({{ $contact->id }}, {{ $contact->is_read ? 'false' : 'true' }})"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-200">
                                <i class="fas fa-{{ $contact->is_read ? 'envelope-open' : 'envelope' }} mr-2"></i>
                                Mark as {{ $contact->is_read ? 'Unread' : 'Read' }}
                            </button>
                        </div>
                        
                        <!-- Delete Button -->
                        <form action="{{ route('admin.contact.destroy', $contact) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this message? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
                                <i class="fas fa-trash mr-2"></i>
                                Delete Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="mt-6 bg-gray-50 rounded-lg p-4">
            <h3 class="font-medium text-gray-900 mb-2">Message Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                <div>
                    <span class="font-medium">Submitted:</span> {{ $contact->created_at->format('M d, Y H:i:s') }}
                </div>
                <div>
                    <span class="font-medium">Status:</span> {{ $contact->is_read ? 'Read' : 'Unread' }}
                </div>
                <div>
                    <span class="font-medium">ID:</span> #{{ $contact->id }}
                </div>
            </div>
        </div>
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