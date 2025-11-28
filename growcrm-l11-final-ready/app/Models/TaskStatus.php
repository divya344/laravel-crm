<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TaskStatus
 *
 * Represents a possible status for a task (e.g., "Pending", "In Progress", "Completed").
 *
 * @property int $taskstatus_id
 * @property string $taskstatus_name
 * @property string|null $taskstatus_color
 * @property string|null $taskstatus_description
 * @property \Carbon\Carbon|null $taskstatus_created
 * @property \Carbon\Carbon|null $taskstatus_updated
 */
class TaskStatus extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'tasks_status';
    protected $primaryKey = 'taskstatus_id';
    protected $guarded = ['taskstatus_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'taskstatus_created';
    const UPDATED_AT = 'taskstatus_updated';

    protected $casts = [
        'taskstatus_created' => 'datetime',
        'taskstatus_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * All tasks associated with this status.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'task_status', 'taskstatus_id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get the formatted display name (e.g., "In Progress").
     */
    public function getFormattedNameAttribute(): string
    {
        return ucwords($this->taskstatus_name ?? 'Unknown Status');
    }

    /**
     * Get the formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->taskstatus_created?->format('d M Y, h:i A');
    }

    /**
     * Get the formatted update date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->taskstatus_updated?->format('d M Y, h:i A');
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope to retrieve only active statuses.
     */
    public function scopeActive($query)
    {
        return $query->where('taskstatus_status', 'active');
    }

    /**
     * Scope to get the default status (e.g., "Pending").
     */
    public function scopeDefault($query)
    {
        return $query->where('taskstatus_is_default', true);
    }
}
