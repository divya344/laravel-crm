<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LeadStatus extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'leads_status';
    protected $primaryKey = 'leadstatus_id';
    protected $guarded = ['leadstatus_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'leadstatus_created';
    const UPDATED_AT = 'leadstatus_updated';

    protected $casts = [
        'leadstatus_created' => 'datetime',
        'leadstatus_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * Leads that belong to this status.
     */
    public function leads()
    {
        return $this->hasMany(Lead::class, 'lead_status', 'leadstatus_id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->leadstatus_created
            ? Carbon::parse($this->leadstatus_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get formatted update date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->leadstatus_updated
            ? Carbon::parse($this->leadstatus_updated)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Display-friendly status name (capitalized and spaced).
     */
    public function getDisplayNameAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->leadstatus_title ?? 'Unknown'));
    }

    /**
     * Display status with color or badge (for UI use).
     */
    public function getStatusBadgeAttribute(): string
    {
        $color = match (strtolower($this->leadstatus_color ?? 'default')) {
            'green' => 'success',
            'red' => 'danger',
            'blue' => 'primary',
            'yellow' => 'warning',
            default => 'secondary',
        };

        return "<span class='badge bg-{$color}'>{$this->display_name}</span>";
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for active lead statuses.
     */
    public function scopeActive($query)
    {
        return $query->where('leadstatus_active', 'yes');
    }

    /**
     * Scope for statuses with a specific pipeline position.
     */
    public function scopePipelineOrder($query)
    {
        return $query->orderBy('leadstatus_position', 'asc');
    }

    /**
     * Scope for recently added statuses.
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('leadstatus_created', '>=', now()->subDays($days));
    }
}
