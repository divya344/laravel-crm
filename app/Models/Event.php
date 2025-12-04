<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Carbon\Carbon;

// Define morph map for eventable relationships
Relation::morphMap([
    'project' => Project::class,
    'lead' => Lead::class,
    'task' => Task::class,
]);

class Event extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'events';
    protected $primaryKey = 'event_id';
    protected $guarded = ['event_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'event_created';
    const UPDATED_AT = 'event_updated';

    protected $casts = [
        'event_created' => 'datetime',
        'event_updated' => 'datetime',
        'event_start' => 'datetime',
        'event_end' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The user who created the event.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'event_creatorid', 'id');
    }

    /**
     * The parent model this event belongs to (Project, Lead, or Task).
     */
    public function eventresource(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Event can have multiple tracking logs.
     */
    public function trackings(): HasMany
    {
        return $this->hasMany(EventTracking::class, 'eventtracking_eventid', 'event_id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted start date (e.g., "07 Nov 2025, 10:00 AM").
     */
    public function getFormattedStartAttribute(): ?string
    {
        return $this->event_start ? $this->event_start->format('d M Y, h:i A') : null;
    }

    /**
     * Get formatted end date.
     */
    public function getFormattedEndAttribute(): ?string
    {
        return $this->event_end ? $this->event_end->format('d M Y, h:i A') : null;
    }

    /**
     * Get duration in hours or minutes.
     */
    public function getDurationAttribute(): ?string
    {
        if (!$this->event_start || !$this->event_end) {
            return null;
        }

        $diffInMinutes = $this->event_end->diffInMinutes($this->event_start);

        if ($diffInMinutes < 60) {
            return "{$diffInMinutes} min";
        }

        $hours = floor($diffInMinutes / 60);
        $minutes = $diffInMinutes % 60;

        return $minutes > 0 ? "{$hours} hr {$minutes} min" : "{$hours} hr";
    }

    /**
     * Display a color-coded event type label (for dashboards/calendars).
     */
    public function getTypeBadgeAttribute(): string
    {
        return match ($this->event_type ?? '') {
            'meeting'   => "<span class='badge bg-primary'>Meeting</span>",
            'deadline'  => "<span class='badge bg-danger'>Deadline</span>",
            'reminder'  => "<span class='badge bg-warning text-dark'>Reminder</span>",
            'call'      => "<span class='badge bg-info text-dark'>Call</span>",
            default     => "<span class='badge bg-secondary'>General</span>",
        };
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope: events happening today.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('event_start', Carbon::today());
    }

    /**
     * Scope: upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('event_start', '>=', now())->orderBy('event_start', 'asc');
    }

    /**
     * Scope: past events.
     */
    public function scopePast($query)
    {
        return $query->where('event_end', '<', now())->orderBy('event_end', 'desc');
    }

    /**
     * Scope: events by creator.
     */
    public function scopeCreatedBy($query, int $userId)
    {
        return $query->where('event_creatorid', $userId);
    }

    /** ─────────────── HELPERS ─────────────── */

    /**
     * Check if the event is currently ongoing.
     */
    public function getIsOngoingAttribute(): bool
    {
        return $this->event_start && $this->event_end
            && now()->between($this->event_start, $this->event_end);
    }

    /**
     * Check if event has ended.
     */
    public function getIsPastAttribute(): bool
    {
        return $this->event_end && $this->event_end->isPast();
    }

    /**
     * Check if event is upcoming.
     */
    public function getIsUpcomingAttribute(): bool
    {
        return $this->event_start && $this->event_start->isFuture();
    }
}
