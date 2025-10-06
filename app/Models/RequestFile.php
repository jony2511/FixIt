<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'original_name',
        'stored_name',
        'file_path',
        'mime_type',
        'file_size',
        'file_extension',
        'is_image',
        'description',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_image' => 'boolean',
            'file_size' => 'integer',
        ];
    }

    // ===== RELATIONSHIPS =====

    /**
     * Get the request this file belongs to
     */
    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    // ===== HELPER METHODS =====

    /**
     * Get the full URL to the file
     */
    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Get formatted file size
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Check if file is downloadable
     */
    public function isDownloadable(): bool
    {
        return file_exists(storage_path('app/public/' . $this->file_path));
    }
}
