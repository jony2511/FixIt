<?php

// Admin Access Test Script
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "🔐 Admin Access Test\n";
echo "=" . str_repeat("=", 30) . "\n\n";

try {
    // Check if admin user exists
    $admin = User::where('email', 'admin@fixit.com')->first();
    
    if ($admin) {
        echo "✅ Admin user found:\n";
        echo "   Email: {$admin->email}\n";
        echo "   Name: {$admin->name}\n";
        echo "   Role: {$admin->role}\n";
        echo "   Is Admin: " . ($admin->isAdmin() ? 'YES ✅' : 'NO ❌') . "\n\n";
    } else {
        echo "❌ Admin user not found!\n";
        echo "   Creating admin user...\n";
        
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@fixit.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        
        echo "✅ Admin user created successfully!\n\n";
    }
    
    echo "🌐 Access Information:\n";
    echo "   Admin Panel URL: http://127.0.0.1:8000/admin\n";
    echo "   Login Credentials:\n";
    echo "   - Email: admin@fixit.com\n";
    echo "   - Password: password\n\n";
    
    echo "📋 Files Status:\n";
    echo "   AdminController.php: " . (file_exists('app/Http/Controllers/AdminController.php') ? '✅ EXISTS' : '❌ MISSING') . "\n";
    echo "   Admin Middleware: " . (file_exists('app/Http/Middleware/EnsureUserIsAdmin.php') ? '✅ EXISTS' : '❌ MISSING') . "\n";
    echo "   Admin Dashboard View: " . (file_exists('resources/views/admin/dashboard.blade.php') ? '✅ EXISTS' : '❌ MISSING') . "\n\n";
    
    echo "✅ Admin access test completed!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}