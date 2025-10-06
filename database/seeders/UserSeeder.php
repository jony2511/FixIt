<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Create default users for testing the FixIT platform
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@fixit.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '+1-555-0101',
            'address' => '123 Admin Street, Tech City, TC 12345',
            'department' => 'IT Administration',
            'employee_id' => 'ADM001',
            'bio' => 'System administrator responsible for managing the FixIT platform and overseeing all maintenance operations.',
            'is_active' => true
        ]);

        // Technician Users
        User::create([
            'name' => 'John Smith',
            'email' => 'john.smith@fixit.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'technician',
            'phone' => '+1-555-0201',
            'address' => '456 Tech Avenue, Repair City, RC 23456',
            'department' => 'IT Support',
            'employee_id' => 'TECH001',
            'bio' => 'Senior IT technician with 5+ years of experience in computer repair and network troubleshooting.',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah.johnson@fixit.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'technician',
            'phone' => '+1-555-0202',
            'address' => '789 Maintenance Road, Fix City, FC 34567',
            'department' => 'Electrical',
            'employee_id' => 'TECH002',
            'bio' => 'Licensed electrician specializing in commercial electrical systems and safety compliance.',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Mike Wilson',
            'email' => 'mike.wilson@fixit.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'technician',
            'phone' => '+1-555-0203',
            'address' => '321 Plumber Lane, Water City, WC 45678',
            'department' => 'Plumbing',
            'employee_id' => 'TECH003',
            'bio' => 'Expert plumber with expertise in commercial plumbing systems and emergency repairs.',
            'is_active' => true
        ]);

        // Regular Users (Students/Employees)
        User::create([
            'name' => 'Alice Brown',
            'email' => 'alice.brown@student.edu',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '+1-555-0301',
            'address' => 'Dorm Building A, Room 201',
            'department' => 'Computer Science',
            'employee_id' => 'STU2024001',
            'bio' => 'Computer Science student, junior year. Interested in web development and AI.',
            'is_active' => true
        ]);

        User::create([
            'name' => 'David Lee',
            'email' => 'david.lee@company.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '+1-555-0302',
            'address' => 'Office Building B, Floor 3',
            'department' => 'Marketing',
            'employee_id' => 'EMP2024001',
            'bio' => 'Marketing manager responsible for digital campaigns and brand management.',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Emily Davis',
            'email' => 'emily.davis@student.edu',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'role' => 'user',
            'phone' => '+1-555-0303',
            'address' => 'Dorm Building C, Room 105',
            'department' => 'Business Administration',
            'employee_id' => 'STU2024002',
            'bio' => 'Business student focusing on operations management and process improvement.',
            'is_active' => true
        ]);

        // Create additional random users for testing
        User::factory(20)->create([
            'role' => 'user',
            'is_active' => true
        ]);
    }
}
