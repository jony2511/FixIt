<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show user dashboard with order statistics
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get order statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)->where('order_status', 'pending')->count();
        $processingOrders = Order::where('user_id', $user->id)->where('order_status', 'processing')->count();
        $completedOrders = Order::where('user_id', $user->id)->where('order_status', 'delivered')->count();
        $totalSpent = Order::where('user_id', $user->id)->where('payment_status', 'paid')->sum('total_amount');
        
        // Get recent orders
        $recentOrders = Order::where('user_id', $user->id)
            ->with(['orderItems.product'])
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'totalOrders', 
            'pendingOrders', 
            'processingOrders', 
            'completedOrders', 
            'totalSpent',
            'recentOrders'
        ));
    }

    /**
     * Show all user orders with filtering and pagination
     */
    public function orders(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status');
        
        $query = Order::where('user_id', $user->id)->with(['orderItems.product']);
        
        // Filter by status if provided
        if ($status && in_array($status, ['pending', 'processing', 'delivered', 'cancelled'])) {
            $query->where('order_status', $status);
        }
        
        $orders = $query->latest()->paginate(10)->withQueryString();
        
        // Get status counts for filter tabs
        $statusCounts = [
            'all' => Order::where('user_id', $user->id)->count(),
            'pending' => Order::where('user_id', $user->id)->where('order_status', 'pending')->count(),
            'processing' => Order::where('user_id', $user->id)->where('order_status', 'processing')->count(),
            'delivered' => Order::where('user_id', $user->id)->where('order_status', 'delivered')->count(),
            'cancelled' => Order::where('user_id', $user->id)->where('order_status', 'cancelled')->count(),
        ];
        
        return view('user.orders.index', compact('orders', 'statusCounts', 'status'));
    }

    /**
     * Show single order details
     */
    public function showOrder($id)
    {
        $user = Auth::user();
        
        $order = Order::where('user_id', $user->id)
            ->with(['orderItems.product'])
            ->findOrFail($id);
            
        return view('user.orders.show', compact('order'));
    }

    /**
     * Generate and download PDF invoice for an order
     */
    public function downloadInvoice($id)
    {
        $user = Auth::user();
        
        $order = Order::where('user_id', $user->id)
            ->with(['orderItems.product', 'user'])
            ->findOrFail($id);
            
        // Only allow invoice download for paid orders
        if ($order->payment_status !== 'paid') {
            return redirect()->back()->with('error', 'Invoice is only available for paid orders.');
        }
        
        // Generate PDF
        $pdf = Pdf::loadView('invoices.order-invoice', compact('order'));
        
        // Set PDF options
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'defaultFont' => 'DejaVu Sans',
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true
        ]);
        
        // Download the PDF
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }

    /**
     * View invoice in browser (optional)
     */
    public function viewInvoice($id)
    {
        $user = Auth::user();
        
        $order = Order::where('user_id', $user->id)
            ->with(['orderItems.product', 'user'])
            ->findOrFail($id);
            
        // Only allow invoice viewing for paid orders
        if ($order->payment_status !== 'paid') {
            return redirect()->back()->with('error', 'Invoice is only available for paid orders.');
        }
        
        // Generate and stream PDF
        $pdf = Pdf::loadView('invoices.order-invoice', compact('order'));
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream('invoice-' . $order->id . '.pdf');
    }

    /**
     * Track order status (AJAX endpoint)
     */
    public function trackOrder($id)
    {
        $user = Auth::user();
        
        $order = Order::where('user_id', $user->id)
            ->with(['orderItems.product'])
            ->findOrFail($id);
            
        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'status' => $order->order_status,
                'order_status' => $order->order_status,
                'created_at' => $order->created_at->format('M d, Y h:i A'),
                'updated_at' => $order->updated_at->format('M d, Y h:i A'),
                'total_amount' => number_format($order->total_amount, 2),
                'payment_method' => $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Payment',
                'transaction_id' => $order->transaction_id
            ]
        ]);
    }
}