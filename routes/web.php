<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AIChatController;
use Illuminate\Support\Facades\Route;

// ===== PUBLIC ROUTES =====
Route::get('/', [HomeController::class, 'index'])->name('home');

// ===== AUTHENTICATED ROUTES =====
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard (newsfeed)
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
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
    
    // Comments
    Route::post('/requests/{request}/comments', [RequestController::class, 'addComment'])->name('requests.comments.store');
    
    // My Requests
    Route::get('/my-requests', [RequestController::class, 'myRequests'])->name('requests.my');
    
    // Assigned Requests (for technicians)
    Route::get('/assigned-requests', [RequestController::class, 'assignedRequests'])->name('requests.assigned');
    
    // AI Chat
    Route::post('/ai-chat', [AIChatController::class, 'chat'])->name('ai.chat');
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
});

// ===== PROFILE ROUTES =====
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
