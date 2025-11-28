<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * MilestoneCategory Model
 *
 * Represents categories or types of milestones (e.g. Planning, Design, Development).
 */
class MilestoneCategory extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'milestone_categories'; // use plural by Laravel convention
    protected $primaryKey = 'milestonecategory_id';
    protected $guarded = ['milestonecategory_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'milestonecategory_created';
    const UPDATED_AT = 'milestonecategory_updated';

    protected $casts = [
        'milestonecategory_created' => 'datetime',
        'milestonecategory_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * Each category can have many milestones.
     */
    public function milestones()
    {
        return $this->hasMany(Milestone::class, 'milestone_categoryid', 'milestonecategory_id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted created date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->milestonecategory_created
            ? Carbon::parse($this->milestonecategory_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get formatted updated date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->milestonecategory_updated
            ? Carbon::parse($this->milestonecategory_updated)->format('d M Y, h:i A')
            : null;
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope to find active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('milestonecategory_status', 'active');
    }

    /**
     * Scope to find categories created within the last X days.
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('milestonecategory_created', '>=', now()->subDays($days));
    }
}
