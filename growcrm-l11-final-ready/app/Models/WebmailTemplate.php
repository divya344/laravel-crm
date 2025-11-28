<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WebmailTemplate extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'webmail_templates';
    protected $primaryKey = 'webmail_template_id';
    protected $guarded = ['webmail_template_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'webmail_template_created';
    const UPDATED_AT = 'webmail_template_updated';

    protected $casts = [
        'webmail_template_created' => 'datetime',
        'webmail_template_updated' => 'datetime',
    ];

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get a human-readable creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->webmail_template_created
            ? Carbon::parse($this->webmail_template_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get a human-readable update date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->webmail_template_updated
            ? Carbon::parse($this->webmail_template_updated)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get a user-friendly title for display.
     */
    public function getReadableTitleAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->webmail_template_name ?? 'Untitled Template'));
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for active templates.
     */
    public function scopeActive($query)
    {
        return $query->where('webmail_template_status', 'active');
    }

    /**
     * Scope for templates created by a specific user.
     */
    public function scopeCreatedBy($query, int $userId)
    {
        return $query->where('webmail_template_creatorid', $userId);
    }

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The user who created this template.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'webmail_template_creatorid', 'id');
    }
}
