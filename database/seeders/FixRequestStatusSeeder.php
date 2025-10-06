<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Request as MaintenanceRequest;
use App\Models\User;
use App\Models\Category;

class FixRequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update any requests with null or empty status
        MaintenanceRequest::whereNull('status')
            ->orWhere('status', '')
            ->update(['status' => 'pending']);

        // Ensure we have at least one test request with proper status
        $user = User::where('email', 'admin@fixit.com')->first();
        $category = Category::first();

        if ($user && $category) {
            // Check if the "Computer Not Starting" request exists
            $request = MaintenanceRequest::where('title', 'Computer Not Starting')->first();
            
            if ($request) {
                // Update it to ensure proper status
                $request->update([
                    'status' => 'pending',
                    'priority' => 'high',
                ]);
                
                $this->command->info('Updated "Computer Not Starting" request with proper status.');
            } else {
                // Create a new test request
                MaintenanceRequest::create([
                    'title' => 'Computer Not Starting',
                    'description' => 'My office computer won\'t turn on. Need urgent assistance.',
                    'location' => 'Office 101',
                    'priority' => 'high',
                    'status' => 'pending',
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'is_urgent' => true,
                    'is_public' => true,
                ]);
                
                $this->command->info('Created test request with proper status.');
            }
        }

        $this->command->info('Request status fix completed.');
    }
}