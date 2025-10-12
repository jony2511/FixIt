<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'category',
        'author_id',
        'views',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    // Auto-generate slug from title
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
            if (empty($blog->published_at)) {
                $blog->published_at = now();
            }
        });
    }

    // Relationship with User (author)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Relationship with Comments
    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }

    // Get approved comments only
    public function approvedComments()
    {
        return $this->hasMany(BlogComment::class)->where('is_approved', true)->whereNull('parent_id')->with('replies', 'user')->latest();
    }

    // Scope for published blogs
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    // Scope for recent blogs
    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    // Get excerpt with word limit
    public function getShortExcerptAttribute()
    {
        return Str::limit($this->excerpt, 100);
    }

    // Get reading time estimate
    public function getReadingTimeAttribute()
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200);
        return $minutes . ' min read';
    }
}
