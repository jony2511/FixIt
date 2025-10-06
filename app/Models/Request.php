<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Request extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'location',
        'priority',
        'status',
        'user_id',
        'category_id',
        'assigned_to',
        'admin_notes',
        'rejection_reason',
        'assigned_at',
        'started_at',
        'completed_at',
        'estimated_cost',
        'estimated_hours',
        'ai_analysis',
        'ai_confidence',
        'is_urgent',
        'is_public',
        'views_count',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'estimated_cost' => 'decimal:2',
            'ai_confidence' => 'decimal:2',
            'ai_analysis' => 'array',
            'is_urgent' => 'boolean',
            'is_public' => 'boolean',
        ];
    }

    // ===== RELATIONSHIPS =====

    /**
     * Get the user who submitted this request
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of this request
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the technician assigned to this request
     */
    public function assignedTechnician()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get all files attached to this request
     */
    public function files()
    {
        return $this->hasMany(RequestFile::class);
    }

    /**
     * Get all comments on this request
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get only public comments (visible to everyone)
     */
    public function publicComments()
    {
        return $this->hasMany(Comment::class)->where('is_internal', false)->orderBy('created_at', 'asc');
    }

    /**
     * Get only internal comments (visible to technicians/admin only)
     */
    public function internalComments()
    {
        return $this->hasMany(Comment::class)->where('is_internal', true)->orderBy('created_at', 'asc');
    }

    // ===== SCOPES =====

    /**
     * Scope for public requests (visible in newsfeed)
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope for pending requests
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for assigned requests
     */
    public function scopeAssigned($query)
    {
        return $query->where('status', 'assigned');
    }

    /**
     * Scope for in-progress requests
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope for completed requests
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for urgent requests
     */
    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    // ===== HELPER METHODS =====

    /**
     * Get status badge color for UI
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'status-pending',
            'assigned' => 'status-in-progress', 
            'in_progress' => 'status-in-progress',
            'completed' => 'status-completed',
            'rejected' => 'status-rejected',
            default => 'status-pending'
        };
    }

    /**
     * Get priority badge color for UI  
     */
    public function getPriorityBadgeColorAttribute(): string
    {
        return match($this->priority) {
            'low' => 'bg-gray-100 text-gray-800',
            'medium' => 'bg-blue-100 text-blue-800',
            'high' => 'bg-orange-100 text-orange-800', 
            'urgent' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get formatted status name
     */
    public function getStatusNameAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pending',
            'assigned' => 'Assigned',
            'in_progress' => 'In Progress', 
            'completed' => 'Completed',
            'rejected' => 'Rejected',
            default => 'Unknown'
        };
    }

    /**
     * Get formatted priority name
     */
    public function getPriorityNameAttribute(): string
    {
        return ucfirst($this->priority);
    }

    /**
     * Check if request can be assigned to a technician
     */
    public function canBeAssigned(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if request can be started (work begun)
     */
    public function canBeStarted(): bool
    {
        return $this->status === 'assigned';
    }

    /**
     * Check if request can be completed
     */
    public function canBeCompleted(): bool
    {
        return in_array($this->status, ['assigned', 'in_progress']);
    }

    /**
     * Check if request can be reopened
     */
    public function canBeReopened(): bool
    {
        return in_array($this->status, ['completed', 'rejected']);
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Assign request to a technician
     */
    public function assignTo(User $technician)
    {
        $this->update([
            'assigned_to' => $technician->id,
            'status' => 'assigned',
            'assigned_at' => now()
        ]);
    }

    /**
     * Start working on the request
     */
    public function startWork()
    {
        $this->update([
            'status' => 'in_progress',
            'started_at' => now()
        ]);
    }

    /**
     * Mark request as completed
     */
    public function markCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
    }
}
