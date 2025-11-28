<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailQueue extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'email_queue';
    protected $primaryKey = 'emailqueue_id';
    protected $guarded = ['emailqueue_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'emailqueue_created';
    const UPDATED_AT = 'emailqueue_updated';

    /** ─────────────── CASTS ─────────────── */
    protected $casts = [
        'emailqueue_created' => 'datetime',
        'emailqueue_updated' => 'datetime',
        'emailqueue_send_at' => 'datetime', // Optional: if queue has scheduled send time
    ];

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope: Pending emails that haven't been sent yet.
     */
    public function scopePending($query)
    {
        return $query->where('emailqueue_status', 'pending');
    }

    /**
     * Scope: Emails that were successfully sent.
     */
    public function scopeSent($query)
    {
        return $query->where('emailqueue_status', 'sent');
    }

    /**
     * Scope: Emails that failed to send.
     */
    public function scopeFailed($query)
    {
        return $query->where('emailqueue_status', 'failed');
    }

    /**
     * Scope: Emails scheduled to send in the future.
     */
    public function scopeScheduled($query)
    {
        return $query->whereNotNull('emailqueue_send_at')
                     ->where('emailqueue_send_at', '>', now());
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted created date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->emailqueue_created
            ? $this->emailqueue_created->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get formatted scheduled send date.
     */
    public function getFormattedSendDateAttribute(): ?string
    {
        return $this->emailqueue_send_at
            ? $this->emailqueue_send_at->format('d M Y, h:i A')
            : 'Immediate';
    }

    /**
     * Get a human-readable status badge (for dashboard or tables).
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->emailqueue_status) {
            'pending' => "<span class='badge bg-warning text-dark'>Pending</span>",
            'sent'    => "<span class='badge bg-success'>Sent</span>",
            'failed'  => "<span class='badge bg-danger'>Failed</span>",
            default   => "<span class='badge bg-secondary'>Unknown</span>",
        };
    }
}
