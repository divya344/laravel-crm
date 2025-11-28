<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class TaskDependency
 *
 * Represents a dependency between two tasks.
 * Example: Task A cannot start until Task B is completed.
 *
 * @property int $tasksdependency_id
 * @property int $task_id
 * @property int $depends_on_id
 * @property \Carbon\Carbon|null $tasksdependency_created
 * @property \Carbon\Carbon|null $tasksdependency_updated
 */
class TaskDependency extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'tasks_dependencies';
    protected $primaryKey = 'tasksdependency_id';
    protected $guarded = ['tasksdependency_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'tasksdependency_created';
    const UPDATED_AT = 'tasksdependency_updated';

    protected $casts = [
        'tasksdependency_created' => 'datetime',
        'tasksdependency_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The task that has this dependency.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id', 'task_id');
    }

    /**
     * The task that this task depends on.
     */
    public function dependsOn(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'depends_on_id', 'task_id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->tasksdependency_created?->format('d M Y, h:i A');
    }

    /**
     * Get formatted update date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->tasksdependency_updated?->format('d M Y, h:i A');
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope to find dependencies for a given task.
     */
    public function scopeForTask($query, int $taskId)
    {
        return $query->where('task_id', $taskId);
    }

    /**
     * Scope to find which tasks depend on a specific task.
     */
    public function scopeDependentsOf($query, int $dependsOnId)
    {
        return $query->where('depends_on_id', $dependsOnId);
    }
}
