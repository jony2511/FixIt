<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Request as MaintenanceRequest;
use App\Models\User;
use App\Models\Category;

class TestRequestsSeeder extends Seeder
{
    /**
     * Run the database seeder to create test requests
     */
    public function run(): void
    {
        // Get or create a regular user
        $user = User::where('role', 'user')->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'testuser@fixit.com',
                'password' => bcrypt('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);
        }

        // Get or create a category
        $category = Category::first();
        if (!$category) {
            $category = Category::create([
                'name' => 'IT Support',
                'description' => 'Computer and network related issues',
                'icon' => 'fas fa-laptop',
                'color' => 'blue',
            ]);
        }

        // Create test requests with different statuses
        $requests = [
            [
                'title' => 'Computer Not Starting',
                'description' => 'My office computer won\'t turn on. Need urgent assistance.',
                'location' => 'Office 101',
                'priority' => 'high',
                'status' => 'pending',
            ],
            [
                'title' => 'WiFi Connection Issues',
                'description' => 'Unable to connect to the office WiFi network.',
                'location' => 'Conference Room A',
                'priority' => 'medium',
                'status' => 'pending',
            ],
            [
                'title' => 'Printer Jam Problem',
                'description' => 'Office printer keeps jamming when printing documents.',
                'location' => 'Print Room',
                'priority' => 'low',
                'status' => 'pending',
            ],
            [
                'title' => 'Software Installation Request',
                'description' => 'Need Adobe Creative Suite installed on my workstation.',
                'location' => 'Design Department',
                'priority' => 'medium',
                'status' => 'pending',
            ],
            [
                'title' => 'Monitor Display Issues',
                'description' => 'Second monitor not displaying correctly, showing distorted colors.',
                'location' => 'Office 205',
                'priority' => 'medium',
                'status' => 'pending',
            ]
        ];

        foreach ($requests as $requestData) {
            MaintenanceRequest::create([
                'title' => $requestData['title'],
                'description' => $requestData['description'],
                'location' => $requestData['location'],
                'priority' => $requestData['priority'],
                'status' => $requestData['status'],
                'user_id' => $user->id,
                'category_id' => $category->id,
                'is_public' => true,
                'is_urgent' => $requestData['priority'] === 'high',
            ]);
        }

        $this->command->info('Test requests created successfully.');
        $this->command->info('You can now test request assignment functionality.');
    }
}