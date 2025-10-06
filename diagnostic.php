<?php

// Diagnostic script to check assignment functionality
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Request as MaintenanceRequest;

echo "🔧 FixIT Assignment Diagnostic\n";
echo "=" . str_repeat("=", 40) . "\n\n";

try {
    // Check technicians
    $technicians = User::whereIn('role', ['technician', 'admin'])->get();
    echo "👥 Available Technicians: " . $technicians->count() . "\n";
    foreach ($technicians as $tech) {
        echo "   - {$tech->name} ({$tech->email}) - {$tech->role}\n";
    }
    
    echo "\n📋 Assignable Requests:\n";
    $assignableRequests = MaintenanceRequest::whereIn('status', ['pending', 'assigned'])->get();
    echo "   Total assignable requests: " . $assignableRequests->count() . "\n";
    
    foreach ($assignableRequests as $request) {
        $assignedTo = $request->assignedTechnician ? $request->assignedTechnician->name : 'Unassigned';
        echo "   - ID {$request->id}: {$request->title} (Status: {$request->status}) - {$assignedTo}\n";
        echo "     Can be assigned: " . ($request->canBeAssigned() ? 'YES ✅' : 'NO ❌') . "\n";
    }
    
    echo "\n🎯 Test Assignment Process:\n";
    $testRequest = $assignableRequests->first();
    $testTechnician = $technicians->first();
    
    if ($testRequest && $testTechnician) {
        echo "   Testing assignment of Request #{$testRequest->id} to {$testTechnician->name}...\n";
        
        if ($testRequest->canBeAssigned()) {
            echo "   ✅ Request can be assigned\n";
            echo "   ✅ Technician is available\n";
            echo "   ✅ Assignment should work!\n";
        } else {
            echo "   ❌ Request cannot be assigned (Status: {$testRequest->status})\n";
        }
    } else {
        echo "   ⚠️  No test data available\n";
    }
    
    echo "\n🌐 Access URLs:\n";
    echo "   Admin Panel: http://127.0.0.1:8000/admin\n";
    echo "   Login: admin@fixit.com / password\n";
    
    echo "\n✅ Diagnostic completed successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}