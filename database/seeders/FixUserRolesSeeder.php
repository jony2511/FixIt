<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FixUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeder to fix user roles and ensure we have proper test users
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@fixit.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@fixit.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create Technician Users
        $technicians = [
            [
                'name' => 'John Technician',
                'email' => 'tech@fixit.com',
                'role' => 'technician',
            ],
            [
                'name' => 'Sarah Martinez',
                'email' => 'technician1@fixit.com',
                'role' => 'technician',
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'technician2@fixit.com',
                'role' => 'technician',
            ]
        ];

        foreach ($technicians as $techData) {
            User::firstOrCreate(
                ['email' => $techData['email']],
                [
                    'name' => $techData['name'],
                    'email' => $techData['email'],
                    'password' => Hash::make('password'),
                    'role' => $techData['role'],
                    'email_verified_at' => now(),
                ]
            );
        }

        // Create Regular Users
        $users = [
            [
                'name' => 'Regular User',
                'email' => 'user@fixit.com',
                'role' => 'user',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'user1@fixit.com',
                'role' => 'user',
            ],
            [
                'name' => 'Bob Wilson',
                'email' => 'user2@fixit.com',
                'role' => 'user',
            ]
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make('password'),
                    'role' => $userData['role'],
                    'email_verified_at' => now(),
                ]
            );
        }

        // Update any existing users that might have missing roles
        User::whereNull('role')->update(['role' => 'user']);
        
        $this->command->info('User roles have been fixed and test users created.');
        $this->command->info('Admin: admin@fixit.com / password');
        $this->command->info('Technician: tech@fixit.com / password');
        $this->command->info('User: user@fixit.com / password');
    }
}