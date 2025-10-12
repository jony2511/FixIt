<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $fillable = [
        'blog_id',
        'user_id',
        'parent_id',
        'name',
        'email',
        'website',
        'comment',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    // Relationship with Blog
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    // Relationship with User (for logged-in users)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Self-referencing relationship for replies
    public function parent()
    {
        return $this->belongsTo(BlogComment::class, 'parent_id');
    }

    // Get all replies
    public function replies()
    {
        return $this->hasMany(BlogComment::class, 'parent_id')->where('is_approved', true)->with('user', 'replies');
    }

    // Scope for approved comments
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // Scope for parent comments only
    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    // Get commenter name
    public function getCommenterNameAttribute()
    {
        return $this->user ? $this->user->name : $this->name;
    }

    // Get commenter avatar
    public function getCommenterAvatarAttribute()
    {
        if ($this->user) {
            return $this->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($this->user->name);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name ?? 'Guest');
    }
}
