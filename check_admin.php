<?php
// Simple admin access test
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

echo "=== Admin Panel Access Test ===\n";

// Check if admin routes are registered
$routes = Route::getRoutes();
$adminRoutes = [];
foreach ($routes as $route) {
    if (str_starts_with($route->uri(), 'admin')) {
        $adminRoutes[] = [
            'uri' => $route->uri(),
            'methods' => $route->methods(),
            'action' => $route->getActionName()
        ];
    }
}

echo "Admin routes found: " . count($adminRoutes) . "\n";
foreach ($adminRoutes as $route) {
    echo "- " . implode('|', $route['methods']) . " " . $route['uri'] . " => " . $route['action'] . "\n";
}

// Check if admin user exists
try {
    $adminUser = DB::table('users')->where('email', 'admin@fixit.com')->first();
    if ($adminUser) {
        echo "\nAdmin user found: {$adminUser->name} ({$adminUser->email})\n";
        echo "Role: {$adminUser->role}\n";
    } else {
        echo "\nNo admin user found!\n";
    }
} catch (Exception $e) {
    echo "\nDatabase error: " . $e->getMessage() . "\n";
}

// Check if AdminController exists and is valid
$controllerPath = __DIR__ . '/app/Http/Controllers/AdminController.php';
if (file_exists($controllerPath)) {
    echo "\nAdminController.php exists\n";
    $content = file_get_contents($controllerPath);
    if (strpos($content, 'class AdminController') !== false) {
        echo "AdminController class found\n";
    }
    if (strpos($content, 'function dashboard') !== false) {
        echo "Dashboard method found\n";
    }
} else {
    echo "\nAdminController.php NOT found!\n";
}

echo "\n=== Test Complete ===\n";