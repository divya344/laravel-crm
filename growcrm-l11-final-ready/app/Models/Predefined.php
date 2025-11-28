<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Predefined Model
 *
 * Represents reusable predefined templates, messages, or configurations
 * created by users in the system.
 */
class Predefined extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'predefined';
    protected $primaryKey = 'predefined_id';
    protected $guarded = ['predefined_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'predefined_created';
    const UPDATED_AT = 'predefined_updated';

    protected $casts = [
        'predefined_created' => 'datetime',
        'predefined_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The user who created this predefined entry.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'predefined_creatorid', 'id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get a human-readable created date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->predefined_created
            ? Carbon::parse($this->predefined_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get a human-readable updated date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->predefined_updated
            ? Carbon::parse($this->predefined_updated)->format('d M Y, h:i A')
            : null;
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope: Only active predefined entries (if such a column exists).
     */
    public function scopeActive($query)
    {
        return $query->where('predefined_status', 'active');
    }
}
