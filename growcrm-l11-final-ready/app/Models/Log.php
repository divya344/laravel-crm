<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Carbon\Carbon;

/**
 * Log Model
 * Represents an activity or event related to contracts, invoices, or subscriptions.
 */
Relation::morphMap([
    'contract' => Contract::class,
    'subscription' => Subscription::class,
    'invoice' => Invoice::class,
]);

class Log extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'logs';
    protected $primaryKey = 'log_id';
    protected $guarded = ['log_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'log_created';
    const UPDATED_AT = 'log_updated';

    protected $casts = [
        'log_created' => 'datetime',
        'log_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The resource (Contract, Subscription, or Invoice) this log belongs to.
     */
    public function logresource()
    {
        return $this->morphTo();
    }

    /**
     * The user who created this log entry.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'log_creatorid', 'id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->log_created
            ? Carbon::parse($this->log_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Formatted update date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->log_updated
            ? Carbon::parse($this->log_updated)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Display readable event type.
     */
    public function getEventTypeFormattedAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->log_event_type ?? 'unknown'));
    }

    /**
     * Display formatted message (shortened for UI).
     */
    public function getShortMessageAttribute(): string
    {
        return strlen($this->log_message ?? '') > 80
            ? substr($this->log_message, 0, 80) . '...'
            : ($this->log_message ?? '');
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for logs by type (e.g., 'contract', 'invoice').
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('logresource_type', $type);
    }

    /**
     * Scope for logs created in the last X days.
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('log_created', '>=', now()->subDays($days));
    }

    /**
     * Scope for logs created by a specific user.
     */
    public function scopeCreatedBy($query, int $userId)
    {
        return $query->where('log_creatorid', $userId);
    }

    /**
     * Scope for filtering by event type.
     */
    public function scopeEventType($query, string $eventType)
    {
        return $query->where('log_event_type', $eventType);
    }

    /** ─────────────── HELPERS ─────────────── */

    /**
     * Return full resource link if exists.
     */
    public function getResourceLinkAttribute(): ?string
    {
        if (!$this->logresource_type || !$this->logresource_id) {
            return null;
        }

        $type = strtolower(class_basename($this->logresource_type));

        return match ($type) {
            'contract' => route('contracts.show', $this->logresource_id),
            'invoice' => route('invoices.show', $this->logresource_id),
            'subscription' => route('subscriptions.show', $this->logresource_id),
            default => null,
        };
    }
}
