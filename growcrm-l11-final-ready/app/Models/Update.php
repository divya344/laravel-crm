<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Update extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'updates'; // explicit table name
    protected $primaryKey = 'update_id';
    protected $guarded = ['update_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'update_created';
    const UPDATED_AT = 'update_updated';

    protected $casts = [
        'update_created' => 'datetime',
        'update_updated' => 'datetime',
    ];

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->update_created
            ? Carbon::parse($this->update_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get formatted updated date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->update_updated
            ? Carbon::parse($this->update_updated)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Return short description for admin dashboards.
     */
    public function getShortDescriptionAttribute(): string
    {
        return strlen($this->update_description ?? '') > 60
            ? substr($this->update_description, 0, 60) . '...'
            : ($this->update_description ?? '');
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for recent updates (last 30 days).
     */
    public function scopeRecent($query)
    {
        return $query->where('update_created', '>=', now()->subDays(30));
    }

    /**
     * Scope for updates by a specific user (if applicable).
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('update_user_id', $userId);
    }

    /**
     * Scope for active/published updates.
     */
    public function scopeActive($query)
    {
        return $query->where('update_status', 'active');
    }
}
