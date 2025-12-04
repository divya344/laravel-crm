<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Unit extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'units';
    protected $primaryKey = 'unit_id';
    protected $guarded = ['unit_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'unit_created';
    const UPDATED_AT = 'unit_updated';

    protected $casts = [
        'unit_created' => 'datetime',
        'unit_updated' => 'datetime',
    ];

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->unit_created
            ? Carbon::parse($this->unit_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get formatted updated date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->unit_updated
            ? Carbon::parse($this->unit_updated)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Return unit name in uppercase (for consistent display).
     */
    public function getUpperNameAttribute(): ?string
    {
        return strtoupper($this->unit_name ?? '');
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for active units.
     */
    public function scopeActive($query)
    {
        return $query->where('unit_active', 1);
    }

    /**
     * Scope to search unit by name.
     */
    public function scopeByName($query, string $name)
    {
        return $query->where('unit_name', 'like', "%{$name}%");
    }
}
