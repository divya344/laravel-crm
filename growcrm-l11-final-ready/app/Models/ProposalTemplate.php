<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * ProposalTemplate Model
 *
 * Represents reusable proposal templates that users can use
 * to generate proposals quickly.
 */
class ProposalTemplate extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'proposal_templates';
    protected $primaryKey = 'proposal_template_id';
    protected $guarded = ['proposal_template_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'proposal_template_created';
    const UPDATED_AT = 'proposal_template_updated';

    protected $casts = [
        'proposal_template_created' => 'datetime',
        'proposal_template_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The user who created this proposal template.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'proposal_template_creatorid', 'id');
    }

    /**
     * Tags related to this proposal template.
     */
    public function tags()
    {
        return $this->morphMany(Tag::class, 'tagresource');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Format the created date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->proposal_template_created
            ? Carbon::parse($this->proposal_template_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Format the updated date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->proposal_template_updated
            ? Carbon::parse($this->proposal_template_updated)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Generate a human-readable version of the template name.
     */
    public function getReadableNameAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->proposal_template_name ?? 'Untitled Template'));
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for active templates.
     */
    public function scopeActive($query)
    {
        return $query->where('proposal_template_status', 'active');
    }

    /**
     * Scope for templates created by a specific user.
     */
    public function scopeCreatedBy($query, int $userId)
    {
        return $query->where('proposal_template_creatorid', $userId);
    }
}
