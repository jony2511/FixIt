<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Request as MaintenanceRequest;
use App\Models\Product;
use App\Models\Order;
use App\Notifications\OrderStatusChangedNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
                'total_contact_messages' => \App\Models\ContactMessage::count(),
                'unread_contact_messages' => \App\Models\ContactMessage::where('is_read', false)->count(),
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

    public function destroyUser(User $user)
    {
        try {
            // Prevent deleting the current admin user
            if ($user->id === auth()->id()) {
                return redirect()->back()
                    ->with('error', 'You cannot delete your own account while logged in.');
            }

            // Check if user has active requests
            $activeRequests = $user->requests()->whereNotIn('status', ['completed', 'cancelled'])->count();
            
            if ($activeRequests > 0) {
                return redirect()->back()
                    ->with('error', "Cannot delete user '{$user->name}' because they have {$activeRequests} active maintenance requests. Please complete or reassign these requests first.");
            }

            // Check if user is assigned as a technician to active requests
            $assignedRequests = MaintenanceRequest::where('assigned_to', $user->id)
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->count();
                
            if ($assignedRequests > 0) {
                return redirect()->back()
                    ->with('error', "Cannot delete user '{$user->name}' because they are assigned to {$assignedRequests} active maintenance requests. Please reassign these requests first.");
            }

            // If user has completed requests, keep them for historical data but anonymize
            $completedRequests = $user->requests()->where('status', 'completed')->count();
            $assignedCompletedRequests = MaintenanceRequest::where('assigned_to', $user->id)
                ->where('status', 'completed')
                ->count();

            if ($completedRequests > 0 || $assignedCompletedRequests > 0) {
                // Anonymize user data instead of complete deletion for data integrity
                $user->update([
                    'name' => 'Deleted User #' . $user->id,
                    'email' => 'deleted_user_' . $user->id . '@deleted.local',
                    'is_active' => false,
                    'role' => 'user',
                    'phone' => null,
                    'address' => null,
                    'department' => null,
                    'employee_id' => null,
                    'bio' => null,
                    'avatar' => null,
                ]);

                return redirect()->back()
                    ->with('success', "User account has been anonymized successfully. Historical data has been preserved for completed requests.");
            } else {
                // Safe to completely delete - no historical data
                $userName = $user->name;
                $user->delete();
                
                return redirect()->back()
                    ->with('success', "User '{$userName}' has been permanently deleted from the system.");
            }

        } catch (\Exception $e) {
            Log::error('User deletion error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Unable to delete user. Please try again or contact system administrator.');
        }
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

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        try {
            \App\Models\Category::create([
                'name' => $request->name,
                'slug' => \Str::slug($request->name),
                'description' => $request->description,
                'icon' => $request->icon,
                'color' => $request->color ?? 'blue',
                'is_active' => $request->has('is_active'),
                'priority' => \App\Models\Category::max('priority') + 1,
            ]);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category created successfully!');
        } catch (\Exception $e) {
            Log::error('Category creation error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Unable to create category. Please try again.')
                ->withInput();
        }
    }

    public function editCategory(\App\Models\Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, \App\Models\Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        try {
            $category->update([
                'name' => $request->name,
                'slug' => \Str::slug($request->name),
                'description' => $request->description,
                'icon' => $request->icon,
                'color' => $request->color ?? 'blue',
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category updated successfully!');
        } catch (\Exception $e) {
            Log::error('Category update error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Unable to update category. Please try again.')
                ->withInput();
        }
    }

    public function destroyCategory(\App\Models\Category $category)
    {
        try {
            // Check if category has requests
            $requestCount = $category->requests()->count();
            
            if ($requestCount > 0) {
                return redirect()->back()
                    ->with('error', "Cannot delete category '{$category->name}' because it has {$requestCount} associated requests. Please reassign the requests first.");
            }

            $category->delete();
            
            return redirect()->route('admin.categories.index')
                ->with('success', 'Category deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Category deletion error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Unable to delete category. Please try again.');
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

    // ===== PRODUCT MANAGEMENT =====

    public function products()
    {
        $products = Product::with('category')
            ->withCount('orderItems')
            ->latest()
            ->paginate(15);

        return view('admin.products', compact('products'));
    }

    public function createProduct()
    {
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'brand' => 'nullable|string|max:255',
            'warranty' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Set stock status based on quantity
        if ($validated['quantity'] == 0) {
            $validated['stock_status'] = 'out_of_stock';
        } elseif ($validated['quantity'] <= 10) {
            $validated['stock_status'] = 'low_stock';
        } else {
            $validated['stock_status'] = 'in_stock';
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function editProduct(Product $product)
    {
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'brand' => 'nullable|string|max:255',
            'warranty' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);
        $product->updateStockStatus();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroyProduct(Product $product)
    {
        // Check if product has orders
        $orderCount = $product->orderItems()->count();
        
        if ($orderCount > 0) {
            return back()->with('error', "Cannot delete this product. It has {$orderCount} order(s). Consider deactivating it instead.");
        }

        // Delete image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function toggleProductActive(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        $status = $product->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Product {$status} successfully!");
    }

    // ===== ORDER MANAGEMENT =====

    public function orders()
    {
        $orders = Order::with(['user', 'items.product'])
            ->latest()
            ->paginate(20);

        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'nullable|in:pending,paid,failed',
        ]);

        // Store old status for notification
        $oldStatus = $order->order_status;
        
        $order->update($validated);

        if ($order->order_status === 'delivered' && !$order->delivered_at) {
            $order->delivered_at = now();
            $order->save();
        }

        // Send notification if order status changed
        if (isset($validated['order_status']) && $oldStatus !== $validated['order_status']) {
            $order->user->notify(new OrderStatusChangedNotification($order, $oldStatus, $validated['order_status']));
        }

        return back()->with('success', 'Order status updated successfully!');
    }
}
