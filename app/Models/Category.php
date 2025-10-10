<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description', 
        'icon',
        'color',
        'priority',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // ===== RELATIONSHIPS =====

    /**
     * Get all requests in this category
     */
    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    /**
     * Get all products in this category
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // ===== SCOPES =====

    /**
     * Scope for active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ===== HELPER METHODS =====

    /**
     * Get the route key for the model (use slug instead of id)
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
