<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Space
 *
 * Represents a space record in the system.
 *
 * @property int $space_id
 * @property string|null $space_name
 * @property string|null $space_description
 * @property Carbon|null $space_created
 * @property Carbon|null $space_updated
 */
class Space extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'spaces';
    protected $primaryKey = 'space_id';
    protected $guarded = ['space_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'space_created';
    const UPDATED_AT = 'space_updated';

    protected $casts = [
        'space_created' => 'datetime',
        'space_updated' => 'datetime',
    ];

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->space_created?->format('d M Y, h:i A');
    }

    /**
     * Formatted update date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->space_updated?->format('d M Y, h:i A');
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for active spaces.
     */
    public function scopeActive($query)
    {
        return $query->where('space_status', 'active');
    }

    /**
     * Scope for recently created spaces (within last 30 days).
     */
    public function scopeRecent($query)
    {
        return $query->where('space_created', '>=', now()->subDays(30));
    }

    /** ─────────────── STATIC HELPERS ─────────────── */

    /**
     * Retrieve a space by its name.
     */
    public static function findByName(string $name)
    {
        return static::where('space_name', $name)->first();
    }
}
