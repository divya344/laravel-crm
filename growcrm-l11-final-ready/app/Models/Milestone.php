<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Milestone Model
 *
 * Represents a milestone within a project, which can have many related tasks.
 */
class Milestone extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'milestones';
    protected $primaryKey = 'milestone_id';
    protected $guarded = ['milestone_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'milestone_created';
    const UPDATED_AT = 'milestone_updated';

    protected $casts = [
        'milestone_created' => 'datetime',
        'milestone_updated' => 'datetime',
        'milestone_due_date' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The user who created this milestone.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'milestone_creatorid', 'id');
    }

    /**
     * The project that this milestone belongs to.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'milestone_projectid', 'project_id');
    }

    /**
     * The tasks associated with this milestone.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'task_milestoneid', 'milestone_id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Return a formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->milestone_created
            ? Carbon::parse($this->milestone_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Return a formatted due date.
     */
    public function getFormattedDueDateAttribute(): ?string
    {
        return $this->milestone_due_date
            ? Carbon::parse($this->milestone_due_date)->format('d M Y')
            : null;
    }

    /**
     * Return the milestone progress in percentage (if stored as numeric).
     */
    public function getProgressPercentageAttribute(): string
    {
        $progress = $this->milestone_progress ?? 0;
        return "{$progress}%";
    }

    /**
     * Return human-readable milestone status.
     */
    public function getLangStatusAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->milestone_status ?? 'pending'));
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for active milestones.
     */
    public function scopeActive($query)
    {
        return $query->where('milestone_status', 'active');
    }

    /**
     * Scope for completed milestones.
     */
    public function scopeCompleted($query)
    {
        return $query->where('milestone_status', 'completed');
    }

    /**
     * Scope for overdue milestones.
     */
    public function scopeOverdue($query)
    {
        return $query->whereDate('milestone_due_date', '<', now())
                     ->where('milestone_status', '!=', 'completed');
    }

    /**
     * Scope for milestones by project.
     */
    public function scopeForProject($query, int $projectId)
    {
        return $query->where('milestone_projectid', $projectId);
    }
}
