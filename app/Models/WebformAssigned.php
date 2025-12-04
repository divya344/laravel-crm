<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WebformAssigned extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'webforms_assigned';
    protected $primaryKey = 'webformassigned_id';
    protected $guarded = ['webformassigned_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'webformassigned_created';
    const UPDATED_AT = 'webformassigned_updated';

    protected $casts = [
        'webformassigned_created' => 'datetime',
        'webformassigned_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * Get the web form this record is linked to.
     */
    public function webform()
    {
        return $this->belongsTo(WebForm::class, 'webformassigned_formid', 'webform_id');
    }

    /**
     * Get the user assigned to this web form.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'webformassigned_userid', 'id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->webformassigned_created
            ? Carbon::parse($this->webformassigned_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get formatted updated date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->webformassigned_updated
            ? Carbon::parse($this->webformassigned_updated)->format('d M Y, h:i A')
            : null;
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for assignments related to a specific web form.
     */
    public function scopeForForm($query, int $formId)
    {
        return $query->where('webformassigned_formid', $formId);
    }

    /**
     * Scope for assignments related to a specific user.
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('webformassigned_userid', $userId);
    }

    /**
     * Scope for recently created assignments (last 30 days).
     */
    public function scopeRecent($query)
    {
        return $query->where('webformassigned_created', '>=', now()->subDays(30));
    }
}
