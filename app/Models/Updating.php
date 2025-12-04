<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Updating extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'updating';
    protected $primaryKey = 'updating_id';
    protected $guarded = ['updating_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'updating_created';
    const UPDATED_AT = 'updating_updated';

    protected $casts = [
        'updating_created' => 'datetime',
        'updating_updated' => 'datetime',
    ];

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->updating_created
            ? Carbon::parse($this->updating_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get formatted updated date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->updating_updated
            ? Carbon::parse($this->updating_updated)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Return short summary (useful for dashboard or listing).
     */
    public function getShortSummaryAttribute(): string
    {
        return strlen($this->updating_description ?? '') > 60
            ? substr($this->updating_description, 0, 60) . '...'
            : ($this->updating_description ?? '');
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for recently updated records (within 30 days).
     */
    public function scopeRecent($query)
    {
        return $query->where('updating_created', '>=', now()->subDays(30));
    }

    /**
     * Scope for active/published updates (if applicable).
     */
    public function scopeActive($query)
    {
        return $query->where('updating_status', 'active');
    }

    /**
     * Scope for filtering updates by user (if table has updating_user_id).
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('updating_user_id', $userId);
    }
}
