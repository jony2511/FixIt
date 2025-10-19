@extends('layouts.sidebar')

@section('title', 'My Requests')
@section('page-title', 'My Requests')
@section('page-description', 'Track all your submitted maintenance requests')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Requests</h1>
            <p class="text-gray-600 mt-2">Track all your submitted maintenance requests</p>
        </div>
        
        <a href="{{ route('requests.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
            + New Request
        </a>
    </div>

    <!-- Requests List -->
    @forelse($requests as $request)
        @php
            $attachmentCount = $request->files->count();
            $previewFiles = $request->files->take(3);
            $extraAttachments = max($attachmentCount - $previewFiles->count(), 0);
            $latestComment = $request->comments->sortByDesc('created_at')->first();
        @endphp
        <article class="relative bg-white rounded-3xl border border-gray-200/80 shadow-sm mb-6 overflow-hidden transition duration-200 hover:shadow-lg hover:-translate-y-1">
            <span class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500"></span>

            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                    <div class="flex items-start gap-4">
                        <div class="relative shrink-0">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 via-indigo-500 to-purple-500 text-white shadow-lg">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m0 0l-3 3m3-3l-3-3m-7 3a9 9 0 1118 0 9 9 0 01-18 0z"></path>
                                </svg>
                            </div>
                            <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider rounded-full bg-slate-900 text-black shadow-lg">#{{ $request->ticket_reference ?? $request->id }}</span>
                        </div>

                        <div>
                            <div class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-wide text-gray-400">
                                <span>Submitted Request</span>
                                <span class="h-1.5 w-1.5 rounded-full bg-gray-200"></span>
                                <span>{{ $request->created_at->format('M d, Y • g:i A') }}</span>
                            </div>
                            <h3 class="mt-1 text-xl md:text-2xl font-semibold text-gray-900 leading-tight">{{ $request->title }}</h3>
                            <div class="mt-3 flex flex-wrap items-center gap-3 text-sm text-gray-500">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path>
                                    </svg>
                                    {{ $request->location }}
                                </span>

                                @if($request->category)
                                    <span class="flex items-center gap-1">
                                        <span class="h-1 w-1 rounded-full bg-gray-300"></span>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full shadow-sm" 
                                              style="background-color: {{ $request->category->color }}20; color: {{ $request->category->color }};">
                                            {{ $request->category->name }}
                                        </span>
                                    </span>
                                @endif

                                <span class="flex items-center gap-1">
                                    <span class="h-1 w-1 rounded-full bg-gray-300"></span>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $request->priority_badge_color }}">
                                        {{ $request->priority_name }}
                                    </span>
                                </span>

                                <span class="flex items-center gap-1">
                                    <span class="h-1 w-1 rounded-full bg-gray-300"></span>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $request->status_badge_color }}">
                                        {{ $request->status_name }}
                                    </span>
                                </span>

                                @if($request->assignedTechnician)
                                    <span class="flex items-center gap-1">
                                        <span class="h-1 w-1 rounded-full bg-gray-300"></span>
                                        <span class="flex items-center gap-2">
                                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </span>
                                            {{ $request->assignedTechnician->name }}
                                        </span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start justify-end">
                        <a href="{{ route('requests.show', $request) }}" 
                           class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-900 hover:border-gray-300 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"></path>
                            </svg>
                            View Details
                        </a>
                    </div>
                </div>

                <div class="mt-6 space-y-6">
                    <p class="text-gray-700 leading-relaxed">{{ \Illuminate\Support\Str::limit($request->description, 220) }}</p>

                    @if($attachmentCount > 0)
                        <div class="flex flex-col gap-3">
                            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L20 7"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 5h5v5"></path>
                                </svg>
                                Attachments
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($previewFiles as $file)
                                    @if($file->is_image)
                                        <div class="relative overflow-hidden rounded-2xl group border border-gray-200">
                                            <img src="{{ asset('storage/' . $file->file_path) }}" 
                                                 alt="Request attachment" 
                                                 class="w-full h-32 object-cover transition duration-200 group-hover:scale-105">
                                            <span class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition"></span>
                                        </div>
                                    @else
                                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="flex items-center justify-between rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-100">
                                            <span>{{ basename($file->file_path) }}</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 5v14m7-7H5"></path>
                                            </svg>
                                        </a>
                                    @endif
                                @endforeach

                                @if($extraAttachments > 0)
                                    <div class="flex items-center justify-center rounded-2xl border border-dashed border-gray-300 bg-white/60 text-gray-500 font-semibold text-sm">
                                        +{{ $extraAttachments }} more
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($latestComment)
                        <div class="rounded-2xl border border-gray-200 bg-gray-50/80 p-4">
                            <div class="flex items-start gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-sm">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l3-3h4a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v6a2 2 0 002 2h3v5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
                                        <span class="font-semibold text-gray-700">{{ $latestComment->user->name ?? 'Team Member' }}</span>
                                        <span class="h-1 w-1 rounded-full bg-gray-300"></span>
                                        <span>{{ optional($latestComment->created_at)->diffForHumans() }}</span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-700 leading-relaxed">{{ \Illuminate\Support\Str::limit($latestComment->content ?? $latestComment->body ?? '', 200) }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-8 border-t border-gray-100 pt-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex flex-wrap items-center gap-5 text-sm text-gray-500">
                        <span class="flex items-center gap-2">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m5 8l-4-4H7a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-3v5z"></path>
                                </svg>
                            </span>
                            {{ $request->comments->count() }} comments
                        </span>

                        <span class="flex items-center gap-2">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-purple-50 text-purple-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8a4 4 0 100 8 4 4 0 000-8z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </span>
                            {{ $request->views_count }} views
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('requests.show', $request) }}" 
                           class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:from-blue-700 hover:to-indigo-700 transition">
                            Manage Request
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </article>
    @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No requests yet</h3>
            <p class="text-gray-500 mb-4">You haven't submitted any maintenance requests yet.</p>
            <a href="{{ route('requests.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                Submit Your First Request
            </a>
        </div>
    @endforelse
    
    <!-- Pagination -->
    @if($requests->hasPages())
        <div class="mt-6">
            {{ $requests->links() }}
        </div>
    @endif
</div>
@endsection