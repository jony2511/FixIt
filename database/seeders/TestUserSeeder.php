<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Create simple test users for easy login
     */
    public function run(): void
    {
        // Delete existing test users if they exist
        User::whereIn('email', ['admin@fixit.com', 'tech@fixit.com', 'user@fixit.com'])->delete();

        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@fixit.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
            'phone' => '+1-555-0001',
            'department' => 'Administration'
        ]);

        // Technician user  
        User::create([
            'name' => 'Tech User', 
            'email' => 'tech@fixit.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'technician',
            'is_active' => true,
            'phone' => '+1-555-0002',
            'department' => 'IT Support'
        ]);

        // Regular user
        User::create([
            'name' => 'Test User',
            'email' => 'user@fixit.com',
            'email_verified_at' => now(), 
            'password' => Hash::make('password'),
            'role' => 'user',
            'is_active' => true,
            'phone' => '+1-555-0003',
            'department' => 'General'
        ]);

        $this->command->info('Test users created successfully!');
        $this->command->line('Admin: admin@fixit.com / password');
        $this->command->line('Technician: tech@fixit.com / password');
        $this->command->line('User: user@fixit.com / password');
    }
}