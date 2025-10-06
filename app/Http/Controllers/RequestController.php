<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as MaintenanceRequest;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use App\Models\RequestFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RequestController extends Controller
{
    /**
     * Display a listing of all requests
     */
    public function index(Request $request)
    {
        $query = MaintenanceRequest::with(['user', 'category', 'assignedTechnician']);

        // Filter by category if specified
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status if specified
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority if specified
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $requests = $query->latest()->paginate(15);
        $categories = Category::active()->orderBy('priority')->get();

        return view('requests.index', compact('requests', 'categories'));
    }

    /**
     * Show the form for creating a new request
     */
    public function create()
    {
        $categories = Category::active()->orderBy('priority')->get();
        return view('requests.create', compact('categories'));
    }

    /**
     * Store a newly created request in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high,urgent',
            'category_id' => 'required|exists:categories,id',
            'files.*' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        $maintenanceRequest = auth()->user()->requests()->create($validated);

        // Handle file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {
                $storedName = time() . '_' . $index . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('request-files', $storedName, 'public');
                
                $maintenanceRequest->files()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'stored_name' => $storedName,
                    'file_path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'file_extension' => $file->getClientOriginalExtension(),
                    'is_image' => str_starts_with($file->getMimeType(), 'image/'),
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()
            ->route('requests.show', $maintenanceRequest)
            ->with('success', 'Request created successfully! We will review it shortly.');
    }

    /**
     * Display the specified request
     */
    public function show(MaintenanceRequest $request)
    {
        // Increment view count
        $request->incrementViews();

        // Load relationships
        $request->load(['user', 'category', 'assignedTechnician', 'files', 'comments.user']);

        // Get available technicians for assignment (admin/technician only)
        $technicians = [];
        if (auth()->user()->canManageRequests()) {
            $technicians = User::where('role', 'technician')
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        }

        return view('requests.show', compact('request', 'technicians'));
    }

    /**
     * Show user's own requests
     */
    public function myRequests()
    {
        $requests = auth()->user()->requests()
            ->with(['category', 'assignedTechnician'])
            ->latest()
            ->paginate(10);

        return view('requests.my-requests', compact('requests'));
    }

    /**
     * Show requests assigned to current user (for technicians)
     */
    public function assignedRequests()
    {
        $user = auth()->user();
        
        if (!$user->canManageRequests()) {
            abort(403, 'Access denied.');
        }

        $requests = MaintenanceRequest::where('assigned_to', $user->id)
            ->with(['user', 'category', 'comments.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('requests.assigned', compact('requests'));
    }

    /**
     * Show requests assigned to current user (alternative method name)
     */
    public function assigned()
    {
        return $this->assignedRequests();
    }

    /**
     * Assign request to technician
     */
    public function assign(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        if (!auth()->user()->canManageRequests()) {
            abort(403, 'Access denied.');
        }

        $validated = $request->validate([
            'technician_id' => 'required|exists:users,id',
        ]);

        $technician = User::findOrFail($validated['technician_id']);
        
        if (!$technician->isTechnician()) {
            return back()->with('error', 'Selected user is not a technician.');
        }

        $maintenanceRequest->assignTo($technician);

        // Add system comment
        Comment::create([
            'request_id' => $maintenanceRequest->id,
            'user_id' => auth()->id(),
            'content' => "Request assigned to {$technician->name}",
            'is_internal' => false,
            'is_update' => true,
        ]);

        return back()->with('success', "Request assigned to {$technician->name}");
    }

    /**
     * Start working on request
     */
    public function start(MaintenanceRequest $request)
    {
        if (!auth()->user()->canManageRequests() || $request->assigned_to !== auth()->id()) {
            abort(403, 'Access denied.');
        }

        if (!$request->canBeStarted()) {
            return back()->with('error', 'Request cannot be started at this time.');
        }

        $request->startWork();

        // Add system comment
        Comment::create([
            'request_id' => $request->id,
            'user_id' => auth()->id(),
            'content' => 'Work started on this request',
            'is_internal' => false,
            'is_update' => true,
        ]);

        return back()->with('success', 'Request marked as in progress.');
    }

    /**
     * Mark request as completed
     */
    public function complete(Request $httpRequest, MaintenanceRequest $request)
    {
        if (!auth()->user()->canManageRequests()) {
            abort(403, 'Access denied.');
        }

        if (!$request->canBeCompleted()) {
            return back()->with('error', 'Request cannot be completed at this time.');
        }

        $validated = $httpRequest->validate([
            'completion_notes' => 'nullable|string|max:1000',
        ]);

        $request->markCompleted();

        // Add completion comment
        $notes = $validated['completion_notes'] ?? 'Request completed successfully.';
        Comment::create([
            'request_id' => $request->id,
            'user_id' => auth()->id(),
            'content' => "Request completed. Notes: {$notes}",
            'is_internal' => false,
            'is_update' => true,
        ]);

        return back()->with('success', 'Request marked as completed.');
    }

    /**
     * Add comment to request
     */
    public function addComment(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'is_internal' => 'boolean'
        ]);

        $comment = $maintenanceRequest->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'is_internal' => $validated['is_internal'] ?? false,
        ]);

        // Load user relationship
        $comment->load('user');

        // Return JSON for AJAX requests
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'is_internal' => $comment->is_internal,
                    'created_at' => $comment->created_at,
                    'user' => [
                        'name' => $comment->user->name,
                        'avatar_url' => $comment->user->avatar_url,
                    ]
                ],
                'total_comments' => $maintenanceRequest->comments()->count()
            ]);
        }

        return redirect()
            ->route('requests.show', $maintenanceRequest)
            ->with('success', 'Comment added successfully!');
    }
}
