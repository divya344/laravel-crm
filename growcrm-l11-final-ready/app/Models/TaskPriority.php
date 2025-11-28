<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TaskPriority
 *
 * Represents task priority levels such as Low, Medium, High, etc.
 *
 * @property int $taskpriority_id
 * @property string $taskpriority_name
 * @property string|null $taskpriority_color
 * @property string|null $taskpriority_description
 * @property \Carbon\Carbon|null $taskpriority_created
 * @property \Carbon\Carbon|null $taskpriority_updated
 */
class TaskPriority extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'tasks_priority';
    protected $primaryKey = 'taskpriority_id';
    protected $guarded = ['taskpriority_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'taskpriority_created';
    const UPDATED_AT = 'taskpriority_updated';

    protected $casts = [
        'taskpriority_created' => 'datetime',
        'taskpriority_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * All tasks that belong to this priority.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'task_priority', 'taskpriority_id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted priority name (e.g., "High Priority").
     */
    public function getFormattedNameAttribute(): string
    {
        return ucfirst($this->taskpriority_name ?? 'Unknown Priority');
    }

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->taskpriority_created?->format('d M Y, h:i A');
    }

    /**
     * Get formatted update date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->taskpriority_updated?->format('d M Y, h:i A');
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope to get active priorities.
     */
    public function scopeActive($query)
    {
        return $query->where('taskpriority_status', 'active');
    }

    /**
     * Scope to get default priority.
     */
    public function scopeDefault($query)
    {
        return $query->where('taskpriority_is_default', true);
    }
}
