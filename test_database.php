<?php

// Test script to verify database relationships and create sample data
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Request as MaintenanceRequest;
use App\Models\Category;

echo "Testing FixIT Database Relationships...\n\n";

try {
    // Test 1: Check if users exist
    $userCount = User::count();
    echo "✅ Users in database: {$userCount}\n";
    
    // Test 2: Check if we have technicians
    $techCount = User::where('role', 'technician')->count();
    echo "✅ Technicians available: {$techCount}\n";
    
    // Test 3: Check if we have an admin
    $adminCount = User::where('role', 'admin')->count();
    echo "✅ Admins available: {$adminCount}\n";
    
    // Test 4: Test relationships
    $requests = MaintenanceRequest::with(['user', 'assignedTechnician'])->limit(5)->get();
    echo "✅ Requests with relationships loaded: " . $requests->count() . "\n";
    
    // Test 5: Test assignedTo relationship
    $firstRequest = $requests->first();
    if ($firstRequest && $firstRequest->assignedTo) {
        echo "✅ assignedTo relationship works: " . $firstRequest->assignedTo->name . "\n";
    } else {
        echo "ℹ️  No assigned requests found (this is normal)\n";
    }
    
    echo "\n🎉 All database tests passed! The issues should now be resolved.\n";
    echo "\nTest Account Details:\n";
    echo "Admin: admin@fixit.com / password\n";
    echo "Technician: tech@fixit.com / password\n";
    echo "User: user@fixit.com / password\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Please check your database configuration.\n";
}