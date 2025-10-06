<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'department',
        'employee_id',
        'bio',
        'avatar',
        'is_active',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    // ===== RELATIONSHIPS =====

    /**
     * Get requests submitted by this user
     */
    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    /**
     * Get requests assigned to this user (for technicians)
     */
    public function assignedRequests()
    {
        return $this->hasMany(Request::class, 'assigned_to');
    }

    /**
     * Get comments made by this user
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // ===== ROLE HELPER METHODS =====

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a technician
     */
    public function isTechnician(): bool
    {
        return $this->role === 'technician';
    }

    /**
     * Check if user is a regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Check if user can manage requests (admin or technician)
     */
    public function canManageRequests(): bool
    {
        return in_array($this->role, ['admin', 'technician']);
    }

    // ===== HELPER METHODS =====

    /**
     * Get user's avatar URL
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        
        // Default avatar using user's initials
        $initials = collect(explode(' ', $this->name))
            ->map(fn($name) => strtoupper(substr($name, 0, 1)))
            ->join('');
            
        return "https://ui-avatars.com/api/?name={$initials}&color=FFFFFF&background=3B82F6";
    }

    /**
     * Get user's role badge color
     */
    public function getRoleBadgeColorAttribute(): string
    {
        return match($this->role) {
            'admin' => 'bg-red-100 text-red-800',
            'technician' => 'bg-blue-100 text-blue-800', 
            'user' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get formatted role name
     */
    public function getRoleNameAttribute(): string
    {
        return ucfirst($this->role);
    }

    /**
     * Update last login timestamp
     */
    public function updateLastLogin()
    {
        $this->update(['last_login' => now()]);
    }
}
