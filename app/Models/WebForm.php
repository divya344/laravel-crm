<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WebForm extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'webforms';
    protected $primaryKey = 'webform_id';
    protected $guarded = ['webform_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'webform_created';
    const UPDATED_AT = 'webform_updated';

    protected $casts = [
        'webform_created' => 'datetime',
        'webform_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The users assigned to this web form.
     */
    public function assigned()
    {
        return $this->belongsToMany(
            User::class,
            'webforms_assigned',
            'webformassigned_formid',
            'webformassigned_userid'
        );
    }

    /**
     * The creator of the web form.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'webform_creatorid', 'id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Format creation date nicely for display.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->webform_created
            ? Carbon::parse($this->webform_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Format last update date nicely for display.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->webform_updated
            ? Carbon::parse($this->webform_updated)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Generate a user-friendly display name.
     */
    public function getReadableNameAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->webform_name ?? 'Untitled Web Form'));
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for active webforms.
     */
    public function scopeActive($query)
    {
        return $query->where('webform_status', 'active');
    }

    /**
     * Scope for webforms created by a specific user.
     */
    public function scopeCreatedBy($query, int $userId)
    {
        return $query->where('webform_creatorid', $userId);
    }

    /**
     * Scope for recently created webforms (last 30 days).
     */
    public function scopeRecent($query)
    {
        return $query->where('webform_created', '>=', now()->subDays(30));
    }
}
