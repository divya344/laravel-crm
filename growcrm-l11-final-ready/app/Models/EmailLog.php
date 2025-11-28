<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'email_log';
    protected $primaryKey = 'emaillog_id';
    protected $guarded = ['emaillog_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'emaillog_created';
    const UPDATED_AT = 'emaillog_updated';

    /** ─────────────── CASTS ─────────────── */
    protected $casts = [
        'emaillog_created' => 'datetime',
        'emaillog_updated' => 'datetime',
        'emaillog_sent_at' => 'datetime', // optional if you store "sent" timestamps
    ];

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope: Only successful email logs.
     */
    public function scopeSuccessful($query)
    {
        return $query->where('emaillog_status', 'sent');
    }

    /**
     * Scope: Only failed email logs.
     */
    public function scopeFailed($query)
    {
        return $query->where('emaillog_status', 'failed');
    }

    /**
     * Scope: Filter by recipient email.
     */
    public function scopeToRecipient($query, string $email)
    {
        return $query->where('emaillog_to', $email);
    }

    /**
     * Scope: Emails sent within the last X days.
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->whereDate('emaillog_created', '>=', now()->subDays($days));
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->emaillog_created ? $this->emaillog_created->format('d M Y, h:i A') : null;
    }

    /**
     * Get human-readable status with badge (for dashboard).
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->emaillog_status) {
            'sent'   => "<span class='badge bg-success'>Sent</span>",
            'failed' => "<span class='badge bg-danger'>Failed</span>",
            default  => "<span class='badge bg-secondary'>Pending</span>",
        };
    }
}
