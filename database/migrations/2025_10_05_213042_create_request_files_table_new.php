<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Create request_files table for file attachments (images, documents)
     * Users can attach files to their maintenance requests
     */
    public function up(): void
    {
        Schema::create('request_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained()->onDelete('cascade'); // Which request this file belongs to
            $table->string('original_name'); // Original filename uploaded by user
            $table->string('stored_name'); // Stored filename on server (usually hashed)
            $table->string('file_path'); // Full path to the file
            $table->string('mime_type'); // File type (image/jpeg, application/pdf, etc.)
            $table->unsignedBigInteger('file_size'); // File size in bytes
            $table->string('file_extension'); // File extension (.jpg, .pdf, etc.)
            $table->boolean('is_image')->default(false); // Quick check if file is an image
            $table->text('description')->nullable(); // Optional description of the file
            $table->integer('sort_order')->default(0); // For ordering multiple files
            $table->timestamps();
            
            // Indexes
            $table->index(['request_id', 'sort_order']);
            $table->index('is_image'); // For filtering images
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_files');
    }
};
