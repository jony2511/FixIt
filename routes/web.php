<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AIChatController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TestSSLCommerzController;
use Illuminate\Support\Facades\Route;

// ===== PUBLIC ROUTES =====
Route::get('/', [HomeController::class, 'index'])->name('home');

// Test SSLCommerz credentials
Route::get('/test-sslcommerz', [TestSSLCommerzController::class, 'testCredentials']);

// Test invoice generation
Route::get('/test-invoice/{order}', function(\App\Models\Order $order) {
    return view('invoices.order-invoice', compact('order'));
})->middleware('auth');

// Shop Routes (Public)
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

// ===== AUTHENTICATED ROUTES =====
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard (newsfeed)
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    // Notification Routes
    Route::get('/notifications/get', [\App\Http\Controllers\NotificationController::class, 'getNotifications'])->name('notifications.get');
    Route::get('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    
    // Request Routes
    Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{request}', [RequestController::class, 'show'])->name('requests.show');
    Route::get('/requests/{request}/edit', [RequestController::class, 'edit'])->name('requests.edit');
    Route::put('/requests/{request}', [RequestController::class, 'update'])->name('requests.update');
    Route::delete('/requests/{request}', [RequestController::class, 'destroy'])->name('requests.destroy');
    
    // Request Actions (for technicians/admins)
    Route::post('/requests/{request}/assign', [RequestController::class, 'assign'])->name('requests.assign');
    Route::post('/requests/{request}/start', [RequestController::class, 'start'])->name('requests.start');
    Route::post('/requests/{request}/complete', [RequestController::class, 'complete'])->name('requests.complete');
    Route::post('/requests/{request}/reject', [RequestController::class, 'reject'])->name('requests.reject');
    Route::post('/requests/{request}/suggest-products', [RequestController::class, 'suggestProducts'])->name('requests.suggest-products');
    
    // Comments
    Route::post('/requests/{request}/comments', [RequestController::class, 'addComment'])->name('requests.comments.store');
    
    // My Requests
    Route::get('/my-requests', [RequestController::class, 'myRequests'])->name('requests.my');
    
    // Assigned Requests (for technicians)
    Route::get('/assigned-requests', [RequestController::class, 'assignedRequests'])->name('requests.assigned');
    
    // AI Chat
    Route::post('/ai-chat', [AIChatController::class, 'chat'])->name('ai.chat');
    
    // Order Routes
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/orders', [OrderController::class, 'placeOrder'])->name('orders.place');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// ===== ADMIN ROUTES =====
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::put('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
    Route::put('/users/{user}/toggle-active', [AdminController::class, 'toggleUserActive'])->name('users.toggle-active');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    
    // Product Management
    Route::get('/products', [AdminController::class, 'products'])->name('products.index');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
    Route::put('/products/{product}/toggle-active', [AdminController::class, 'toggleProductActive'])->name('products.toggle-active');
    
    // Order Management
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::put('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
});

// ===== USER DASHBOARD ROUTES =====
Route::middleware('auth')->group(function () {
    // User Dashboard and Order Management
    Route::get('/user/dashboard', [\App\Http\Controllers\UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user/orders', [\App\Http\Controllers\UserDashboardController::class, 'orders'])->name('user.orders');
    Route::get('/user/orders/{order}', [\App\Http\Controllers\UserDashboardController::class, 'showOrder'])->name('user.orders.show');
    Route::get('/user/orders/{order}/track', [\App\Http\Controllers\UserDashboardController::class, 'trackOrder'])->name('user.orders.track');
    
    // PDF Invoice Generation
    Route::get('/user/orders/{order}/invoice', [\App\Http\Controllers\UserDashboardController::class, 'downloadInvoice'])->name('user.orders.invoice');
    Route::get('/user/orders/{order}/invoice/view', [\App\Http\Controllers\UserDashboardController::class, 'viewInvoice'])->name('user.orders.invoice.view');
});

// ===== PAYMENT ROUTES =====
// Protected payment initiation route
Route::middleware('auth')->group(function () {
    Route::get('/payment/initiate', [\App\Http\Controllers\PaymentController::class, 'initiatePayment'])->name('payment.initiate');
});

// Public payment callback routes (SSLCommerz callbacks) - Handle both GET and POST
Route::match(['get', 'post'], '/payment/success', [\App\Http\Controllers\PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::match(['get', 'post'], '/payment/fail', [\App\Http\Controllers\PaymentController::class, 'paymentFail'])->name('payment.fail');
Route::match(['get', 'post'], '/payment/cancel', [\App\Http\Controllers\PaymentController::class, 'paymentCancel'])->name('payment.cancel');
Route::post('/payment/ipn', [\App\Http\Controllers\PaymentController::class, 'paymentIPN'])->name('payment.ipn');

// Test payment callback (for debugging)
Route::match(['get', 'post'], '/payment/test-success', [\App\Http\Controllers\TestPaymentController::class, 'testSuccess'])->name('payment.test-success');



// ===== PROFILE ROUTES =====
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
