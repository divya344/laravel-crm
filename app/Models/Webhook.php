<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Webhook extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'webhooks';
    protected $primaryKey = 'webhook_id';
    protected $guarded = ['webhook_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'webhook_created';
    const UPDATED_AT = 'webhook_updated';

    protected $casts = [
        'webhook_created' => 'datetime',
        'webhook_updated' => 'datetime',
    ];

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Format created date for display.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->webhook_created
            ? Carbon::parse($this->webhook_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Format updated date for display.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->webhook_updated
            ? Carbon::parse($this->webhook_updated)->format('d M Y, h:i A')
            : null;
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for active webhooks.
     */
    public function scopeActive($query)
    {
        return $query->where('webhook_status', 'active');
    }

    /**
     * Scope for webhooks triggered by a specific event.
     */
    public function scopeForEvent($query, string $event)
    {
        return $query->where('webhook_event', $event);
    }

    /**
     * Scope for webhooks created by a specific user (if applicable).
     */
    public function scopeCreatedBy($query, int $userId)
    {
        return $query->where('webhook_creatorid', $userId);
    }

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The user who created this webhook.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'webhook_creatorid', 'id');
    }
}
