<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LeadAssigned extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'leads_assigned';
    protected $primaryKey = 'leadsassigned_id';
    protected $guarded = ['leadsassigned_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'leadsassigned_created';
    const UPDATED_AT = 'leadsassigned_updated';

    protected $casts = [
        'leadsassigned_created' => 'datetime',
        'leadsassigned_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The lead that this record belongs to.
     */
    public function lead()
    {
        return $this->belongsTo(Lead::class, 'leadsassigned_leadid', 'lead_id');
    }

    /**
     * The user assigned to the lead.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'leadsassigned_userid', 'id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->leadsassigned_created
            ? Carbon::parse($this->leadsassigned_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get formatted update date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->leadsassigned_updated
            ? Carbon::parse($this->leadsassigned_updated)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get the full name of the assigned user (shortcut accessor).
     */
    public function getAssignedUserNameAttribute(): string
    {
        return $this->user
            ? ($this->user->name ?? ($this->user->first_name . ' ' . $this->user->last_name))
            : 'Unassigned';
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for a specific lead.
     */
    public function scopeForLead($query, int $leadId)
    {
        return $query->where('leadsassigned_leadid', $leadId);
    }

    /**
     * Scope for a specific user.
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('leadsassigned_userid', $userId);
    }

    /**
     * Scope for recently assigned leads (default 7 days).
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('leadsassigned_created', '>=', now()->subDays($days));
    }
}
