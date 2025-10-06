<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Create requests table - the main table for maintenance/service requests
     * This is like "posts" in a Facebook-like system
     */
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Request title/subject
            $table->text('description'); // Detailed description of the issue
            $table->string('location'); // Where the issue is located
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['pending', 'assigned', 'in_progress', 'completed', 'rejected'])->default('pending');
            
            // Relationships
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who submitted the request
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null'); // Request category
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null'); // Assigned technician
            
            // Additional fields
            $table->text('admin_notes')->nullable(); // Internal notes by admin/technician
            $table->text('rejection_reason')->nullable(); // Reason if request is rejected
            $table->timestamp('assigned_at')->nullable(); // When request was assigned
            $table->timestamp('started_at')->nullable(); // When work started
            $table->timestamp('completed_at')->nullable(); // When work was completed
            $table->decimal('estimated_cost', 10, 2)->nullable(); // Estimated cost if applicable
            $table->integer('estimated_hours')->nullable(); // Estimated time to complete
            
            // AI categorization fields
            $table->json('ai_analysis')->nullable(); // Store AI analysis results
            $table->decimal('ai_confidence', 5, 2)->nullable(); // AI confidence score (0-100)
            
            // Tracking and audit
            $table->boolean('is_urgent')->default(false); // Flag for urgent requests
            $table->boolean('is_public')->default(true); // Show in public newsfeed
            $table->integer('views_count')->default(0); // How many people viewed this request
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['status', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index(['assigned_to', 'status']);
            $table->index(['category_id', 'status']);
            $table->index(['is_public', 'status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
