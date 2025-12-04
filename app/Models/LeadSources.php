<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LeadSources extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'leads_sources';
    protected $primaryKey = 'leadsources_id';
    protected $guarded = ['leadsources_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'leadsources_created';
    const UPDATED_AT = 'leadsources_updated';

    protected $casts = [
        'leadsources_created' => 'datetime',
        'leadsources_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * Leads that originated from this source.
     */
    public function leads()
    {
        return $this->hasMany(Lead::class, 'lead_sourceid', 'leadsources_id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->leadsources_created
            ? Carbon::parse($this->leadsources_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get formatted update date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->leadsources_updated
            ? Carbon::parse($this->leadsources_updated)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Returns a user-friendly version of the source name.
     */
    public function getDisplayNameAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->leadsources_name ?? 'Unknown Source'));
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for active sources.
     */
    public function scopeActive($query)
    {
        return $query->where('leadsources_status', 'active');
    }

    /**
     * Scope for recently added sources (default: 30 days).
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('leadsources_created', '>=', now()->subDays($days));
    }

    /** ─────────────── HELPERS ─────────────── */

    /**
     * Total number of leads from this source.
     */
    public function getTotalLeadsCountAttribute(): int
    {
        return $this->leads()->count();
    }
}
