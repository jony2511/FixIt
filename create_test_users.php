<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Simple test user seeder for easy login testing
 */

// Admin user
try {
    User::firstOrCreate(
        ['email' => 'admin@fixit.com'],
        [
            'name' => 'Admin User',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
            'phone' => '+1-555-0001',
            'department' => 'Administration'
        ]
    );
    echo "Admin user created: admin@fixit.com / password\n";
} catch (Exception $e) {
    echo "Error creating admin user: " . $e->getMessage() . "\n";
}

// Technician user  
try {
    User::firstOrCreate(
        ['email' => 'tech@fixit.com'],
        [
            'name' => 'Tech User', 
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'technician',
            'is_active' => true,
            'phone' => '+1-555-0002',
            'department' => 'IT Support'
        ]
    );
    echo "Technician user created: tech@fixit.com / password\n";
} catch (Exception $e) {
    echo "Error creating tech user: " . $e->getMessage() . "\n";
}

// Regular user
try {
    User::firstOrCreate(
        ['email' => 'user@fixit.com'],
        [
            'name' => 'Test User',
            'email_verified_at' => now(), 
            'password' => Hash::make('password'),
            'role' => 'user',
            'is_active' => true,
            'phone' => '+1-555-0003',
            'department' => 'General'
        ]
    );
    echo "Regular user created: user@fixit.com / password\n";
} catch (Exception $e) {
    echo "Error creating regular user: " . $e->getMessage() . "\n";
}