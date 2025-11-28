<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * PaymentSession Model
 *
 * Represents a payment session for tracking online or temporary payment states.
 */
class PaymentSession extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'payment_sessions';
    protected $primaryKey = 'session_id';
    protected $guarded = ['session_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'session_created';
    const UPDATED_AT = 'session_updated';

    protected $casts = [
        'session_created'     => 'datetime',
        'session_updated'     => 'datetime',
        'session_expires_at'  => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The payment record associated with this session.
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'session_paymentid', 'payment_id');
    }

    /**
     * The client who initiated this session.
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'session_clientid', 'client_id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Determine if the session has expired.
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->session_expires_at
            ? Carbon::now()->greaterThan($this->session_expires_at)
            : false;
    }

    /**
     * Get formatted created date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->session_created
            ? Carbon::parse($this->session_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get formatted expiry date.
     */
    public function getFormattedExpiryAttribute(): ?string
    {
        return $this->session_expires_at
            ? Carbon::parse($this->session_expires_at)->format('d M Y, h:i A')
            : null;
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope: Only active (non-expired) sessions.
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('session_expires_at')
              ->orWhere('session_expires_at', '>', now());
        });
    }

    /**
     * Scope: Only expired sessions.
     */
    public function scopeExpired($query)
    {
        return $query->where('session_expires_at', '<', now());
    }
}
