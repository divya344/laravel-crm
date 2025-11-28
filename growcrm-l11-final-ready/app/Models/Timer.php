<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Timer extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'timers';
    protected $primaryKey = 'timer_id';
    protected $guarded = ['timer_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'timer_created';
    const UPDATED_AT = 'timer_updated';

    protected $casts = [
        'timer_created' => 'datetime',
        'timer_updated' => 'datetime',
        'timer_start'   => 'datetime',
        'timer_end'     => 'datetime',
        'timer_duration' => 'integer',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The user who created the timer.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'timer_creatorid', 'id');
    }

    /**
     * The task that this timer is tracking.
     */
    public function task()
    {
        return $this->belongsTo(Task::class, 'timer_taskid', 'task_id');
    }

    /**
     * The project that this timer is related to (if applicable).
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'timer_projectid', 'project_id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted created date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->timer_created
            ? Carbon::parse($this->timer_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get total time in hours and minutes (formatted).
     */
    public function getFormattedDurationAttribute(): string
    {
        if (!$this->timer_start || !$this->timer_end) {
            return '0h 00m';
        }

        $seconds = $this->timer_end->diffInSeconds($this->timer_start);
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        return sprintf('%dh %02dm', $hours, $minutes);
    }

    /**
     * Check if timer is currently running.
     */
    public function getIsRunningAttribute(): bool
    {
        return is_null($this->timer_end);
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope: Active/running timers.
     */
    public function scopeActive($query)
    {
        return $query->whereNull('timer_end');
    }

    /**
     * Scope: Completed timers.
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('timer_end');
    }

    /**
     * Scope: Timers for a specific user.
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('timer_creatorid', $userId);
    }
}
