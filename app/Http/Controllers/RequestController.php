<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as MaintenanceRequest;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use App\Models\RequestFile;
use App\Models\Product;
use App\Notifications\CommentAddedNotification;
use App\Notifications\TechnicianAssignedNotification;
use App\Notifications\RequestAssignedNotification;
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
        $technicians = collect([]);
        $availableProducts = collect([]);
        $suggestedProductsList = collect([]);
        
        if (auth()->user()->canManageRequests()) {
            $technicians = User::where('role', 'technician')
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
                
            // Get products from the same category for suggestion
            if ($request->category_id) {
                $availableProducts = Product::where('category_id', $request->category_id)
                    ->where('is_active', true)
                    ->where('quantity', '>', 0)
                    ->orderBy('name')
                    ->get();
            }
            
            // Get suggested products if any
            if ($request->suggested_products && is_array($request->suggested_products)) {
                $suggestedProductsList = Product::whereIn('id', $request->suggested_products)->get();
            }
        }

        return view('requests.show', compact('request', 'technicians', 'availableProducts', 'suggestedProductsList'));
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
    public function assign(Request $httpRequest, MaintenanceRequest $request)
    {
        if (!auth()->user()->canManageRequests()) {
            abort(403, 'Access denied.');
        }

        $validated = $httpRequest->validate([
            'technician_id' => 'required|exists:users,id',
        ]);

        try {
            $technician = User::findOrFail($validated['technician_id']);
            
            if (!$technician->isTechnician() && !$technician->isAdmin()) {
                return back()->with('error', 'Selected user is not a technician or admin.');
            }

            // Check if request can be assigned
            if (!$request->canBeAssigned()) {
                $status = $request->status ?: 'unknown';
                return back()->with('error', "This request cannot be assigned. Current status: '{$status}'. Only pending or assigned requests can be (re)assigned.");
            }

            $request->assignTo($technician);

            // Add system comment
            Comment::create([
                'request_id' => $request->id,
                'user_id' => auth()->id(),
                'content' => "Request assigned to {$technician->name}",
                'is_internal' => false,
                'is_update' => true,
            ]);

            // Send notification to request owner (if they're not the one assigning)
            if (auth()->id() !== $request->user_id) {
                $request->user->notify(new TechnicianAssignedNotification($request, $technician));
            }

            // Send notification to the technician
            $technician->notify(new RequestAssignedNotification($request));

            return back()->with('success', "Request assigned to {$technician->name}");
            
        } catch (\Exception $e) {
            \Log::error('Request assignment failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Failed to assign request. Please try again or contact administrator.');
        }
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
    public function addComment(Request $httpRequest, MaintenanceRequest $request)
    {
        $validated = $httpRequest->validate([
            'content' => 'required|string|max:1000',
            'is_internal' => 'boolean'
        ]);

        $comment = $request->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'is_internal' => $validated['is_internal'] ?? false,
        ]);

        // Load user relationship
        $comment->load('user');

        // Send notification to request owner if commenter is not the owner
        if (auth()->id() !== $request->user_id) {
            $request->user->notify(
                new CommentAddedNotification($request, auth()->user(), $validated['content'])
            );
        }

        // Return JSON for AJAX requests
        if ($httpRequest->wantsJson()) {
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
                'total_comments' => $request->comments()->count()
            ]);
        }

        return redirect()
            ->route('requests.show', $request)
            ->with('success', 'Comment added successfully!');
    }

    // Suggest Products for Replacement
    public function suggestProducts(Request $httpRequest, MaintenanceRequest $request)
    {
        if (!auth()->user()->canManageRequests()) {
            abort(403, 'Access denied.');
        }

        $validated = $httpRequest->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
            'replacement_notes' => 'nullable|string|max:1000',
        ]);

        $request->update([
            'suggested_products' => $validated['product_ids'],
            'replacement_notes' => $validated['replacement_notes'] ?? null,
        ]);

        // Get product details and create product links in comment
        $products = Product::whereIn('id', $validated['product_ids'])->get();
        $productDetails = $products->map(function($product) {
            return "• {$product->name} - \${$product->price}";
        })->join("\n");

        // Add comment about suggested products with product details
        $productCount = count($validated['product_ids']);
        $commentContent = "Suggested {$productCount} replacement product(s) for this request:\n\n{$productDetails}";
        
        if (!empty($validated['replacement_notes'])) {
            $commentContent .= "\n\n" . $validated['replacement_notes'];
        }

        Comment::create([
            'request_id' => $request->id,
            'user_id' => auth()->id(),
            'content' => $commentContent,
            'is_internal' => false,
            'is_update' => true,
        ]);

        return back()->with('success', 'Products suggested successfully!');
    }
}
