<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EventTracking extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'events_tracking';
    protected $primaryKey = 'eventtracking_id';
    protected $guarded = ['eventtracking_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'eventtracking_created';
    const UPDATED_AT = 'eventtracking_updated';

    protected $casts = [
        'eventtracking_created' => 'datetime',
        'eventtracking_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The event this tracking belongs to.
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'eventtracking_eventid', 'event_id');
    }

    /**
     * The user who performed the tracking action.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'eventtracking_userid', 'id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted created date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->eventtracking_created
            ? $this->eventtracking_created->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get time since created (e.g., "2 hours ago").
     */
    public function getTimeAgoAttribute(): ?string
    {
        return $this->eventtracking_created
            ? $this->eventtracking_created->diffForHumans()
            : null;
    }

    /**
     * Display the action in a readable format.
     * Example: 'Event Started', 'Status Changed', etc.
     */
    public function getReadableActionAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->eventtracking_action ?? 'unknown'));
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope: logs related to a specific event.
     */
    public function scopeForEvent($query, int $eventId)
    {
        return $query->where('eventtracking_eventid', $eventId);
    }

    /**
     * Scope: get only recent logs (default: last 7 days).
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('eventtracking_created', '>=', now()->subDays($days));
    }

    /**
     * Scope: filter by action type.
     */
    public function scopeAction($query, string $action)
    {
        return $query->where('eventtracking_action', $action);
    }

    /** ─────────────── HELPERS ─────────────── */

    /**
     * Generate a short readable summary (for notifications or activity feed).
     */
    public function getSummaryAttribute(): string
    {
        $user = $this->user->name ?? 'System';
        $action = $this->readable_action;
        $event = $this->event->event_title ?? 'Untitled Event';

        return "{$user} {$action} on {$event}";
    }
}
