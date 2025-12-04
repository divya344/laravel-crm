<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class Settings
 *
 * Represents application configuration or global settings.
 *
 * @property int $settings_id
 * @property string|null $key
 * @property string|null $value
 * @property Carbon|null $settings_created
 * @property Carbon|null $settings_updated
 */
class Settings extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'settings';
    protected $primaryKey = 'settings_id';
    protected $guarded = ['settings_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'settings_created';
    const UPDATED_AT = 'settings_updated';

    protected $casts = [
        'settings_created' => 'datetime',
        'settings_updated' => 'datetime',
    ];

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted created date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->settings_created?->format('d M Y, h:i A');
    }

    /**
     * Get formatted updated date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->settings_updated?->format('d M Y, h:i A');
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope to get a setting by key.
     */
    public function scopeByKey($query, string $key)
    {
        return $query->where('key', $key);
    }

    /** ─────────────── STATIC HELPERS ─────────────── */

    /**
     * Retrieve a setting value by key, or return default.
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
