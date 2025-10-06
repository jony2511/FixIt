<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'user_id',
        'content',
        'is_internal',
        'is_update',
    ];

    protected function casts(): array
    {
        return [
            'is_internal' => 'boolean',
            'is_update' => 'boolean',
        ];
    }

    // ===== RELATIONSHIPS =====

    /**
     * Get the request this comment belongs to
     */
    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    /**
     * Get the user who made this comment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ===== SCOPES =====

    /**
     * Scope for public comments (not internal)
     */
    public function scopePublic($query)
    {
        return $query->where('is_internal', false);
    }

    /**
     * Scope for internal comments (technician/admin only)
     */
    public function scopeInternal($query)
    {
        return $query->where('is_internal', true);
    }

    /**
     * Scope for update comments (system generated)
     */
    public function scopeUpdates($query)
    {
        return $query->where('is_update', true);
    }
}
