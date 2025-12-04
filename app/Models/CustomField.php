<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'customfields';
    protected $primaryKey = 'customfields_id';
    protected $guarded = ['customfields_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'customfields_created';
    const UPDATED_AT = 'customfields_updated';

    /** ─────────────── CASTS ─────────────── */
    protected $casts = [
        'customfields_created' => 'datetime',
        'customfields_updated' => 'datetime',
    ];

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope to get only active custom fields.
     */
    public function scopeActive($query)
    {
        return $query->where('customfields_status', 'active');
    }

    /**
     * Scope to get custom fields for a specific module (e.g., 'projects', 'clients').
     */
    public function scopeForModule($query, string $module)
    {
        return $query->where('customfields_module', $module);
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Returns a human-readable label (fallback to field name).
     */
    public function getDisplayLabelAttribute(): string
    {
        return $this->customfields_label ?? ucfirst(str_replace('_', ' ', $this->customfields_name));
    }
}
