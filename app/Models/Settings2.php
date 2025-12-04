<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Settings2
 *
 * Represents additional or secondary application settings.
 *
 * @property int $settings2_id
 * @property string|null $key
 * @property string|null $value
 * @property Carbon|null $settings2_created
 * @property Carbon|null $settings2_updated
 */
class Settings2 extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'settings2';
    protected $primaryKey = 'settings2_id';
    protected $guarded = ['settings2_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'settings2_created';
    const UPDATED_AT = 'settings2_updated';

    protected $casts = [
        'settings2_created' => 'datetime',
        'settings2_updated' => 'datetime',
    ];

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->settings2_created?->format('d M Y, h:i A');
    }

    /**
     * Get formatted update date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->settings2_updated?->format('d M Y, h:i A');
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope to find setting by key.
     */
    public function scopeByKey($query, string $key)
    {
        return $query->where('key', $key);
    }

    /** ─────────────── STATIC HELPERS ─────────────── */

    /**
     * Retrieve a setting value by key, with optional default.
     */
    public static function getValue(string $key, $default = null)
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Update or create a setting.
     */
    public static function setValue(string $key, $value): bool
    {
        return static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
