<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Create default categories for maintenance requests
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'IT Support',
                'description' => 'Computer issues, network problems, software installation, account access',
                'icon' => 'computer',
                'color' => '#3B82F6', // Blue
                'priority' => 1
            ],
            [
                'name' => 'Electrical',
                'description' => 'Lighting issues, power outlets, electrical repairs, circuit problems',
                'icon' => 'lightning-bolt',
                'color' => '#F59E0B', // Amber
                'priority' => 2
            ],
            [
                'name' => 'Plumbing',
                'description' => 'Water leaks, drain clogs, toilet repairs, faucet issues',
                'icon' => 'water',
                'color' => '#06B6D4', // Cyan
                'priority' => 3
            ],
            [
                'name' => 'HVAC',
                'description' => 'Heating, ventilation, air conditioning, temperature control',
                'icon' => 'snowflake',
                'color' => '#8B5CF6', // Purple
                'priority' => 4
            ],
            [
                'name' => 'Maintenance',
                'description' => 'General repairs, painting, cleaning, facility maintenance',
                'icon' => 'tools',
                'color' => '#10B981', // Emerald
                'priority' => 5
            ],
            [
                'name' => 'Security',
                'description' => 'Access control, locks, security cameras, safety issues',
                'icon' => 'shield',
                'color' => '#EF4444', // Red
                'priority' => 6
            ],
            [
                'name' => 'Furniture',
                'description' => 'Desks, chairs, tables, storage, furniture repairs',
                'icon' => 'home',
                'color' => '#84CC16', // Lime
                'priority' => 7
            ],
            [
                'name' => 'Cleaning',
                'description' => 'Janitorial services, spill cleanup, waste management',
                'icon' => 'sparkles',
                'color' => '#F97316', // Orange
                'priority' => 8
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'icon' => $category['icon'],
                'color' => $category['color'],
                'priority' => $category['priority'],
                'is_active' => true
            ]);
        }
    }
}
