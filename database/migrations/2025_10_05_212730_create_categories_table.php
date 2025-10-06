<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Create categories table for request categorization
     * Categories: IT, Electrical, Plumbing, Maintenance, etc.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Category name (e.g., "IT Support", "Electrical")
            $table->string('slug')->unique(); // URL-friendly version (e.g., "it-support")
            $table->text('description')->nullable(); // Category description
            $table->string('icon')->nullable(); // Icon class or path for UI
            $table->string('color', 7)->default('#3B82F6'); // Hex color for category display
            $table->integer('priority')->default(0); // For ordering categories
            $table->boolean('is_active')->default(true); // Enable/disable category
            $table->timestamps();
            
            // Index for performance
            $table->index(['is_active', 'priority']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
