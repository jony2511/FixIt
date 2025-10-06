<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Create comments table for social interaction on requests
     * Like Facebook comments on posts
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained()->onDelete('cascade'); // Which request this comment belongs to
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who made the comment
            $table->text('content'); // Comment content
            $table->boolean('is_internal')->default(false); // Internal comment (only visible to technicians/admin)
            $table->boolean('is_update')->default(false); // Status update comment (auto-generated)
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['request_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index('is_internal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
