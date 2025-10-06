<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Add role system to users table for FixIT platform
     * Roles: user (default), technician, admin
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add role column with default value of 'user'
            $table->enum('role', ['user', 'technician', 'admin'])->default('user')->after('email');
            
            // Add additional profile fields for better user management
            $table->string('phone')->nullable()->after('role');
            $table->text('address')->nullable()->after('phone');
            $table->string('department')->nullable()->after('address'); // For employees/students
            $table->string('employee_id')->nullable()->after('department'); // Employee/Student ID
            $table->text('bio')->nullable()->after('employee_id'); // User bio/description
            $table->string('avatar')->nullable()->after('bio'); // Profile picture path
            $table->boolean('is_active')->default(true)->after('avatar'); // Account status
            $table->timestamp('last_login')->nullable()->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove all added columns
            $table->dropColumn([
                'role', 
                'phone', 
                'address', 
                'department', 
                'employee_id', 
                'bio', 
                'avatar', 
                'is_active', 
                'last_login'
            ]);
        });
    }
};
