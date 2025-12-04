<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Fooo
 *
 * Example model template (placeholder).
 * You can rename and reuse this for new database tables.
 *
 * @property int $fooo_id
 * @property string|null $fooo_name
 * @property \Carbon\Carbon|null $fooo_created
 * @property \Carbon\Carbon|null $fooo_updated
 */
class SCAFFOLDING extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'fooo'; // 👈 Update this if your actual table name differs
    protected $primaryKey = 'fooo_id';
    protected $guarded = ['fooo_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'fooo_created';
    const UPDATED_AT = 'fooo_updated';

    protected $casts = [
        'fooo_created' => 'datetime',
        'fooo_updated' => 'datetime',
    ];

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Example accessor: Return formatted created date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->fooo_created?->format('d M Y, h:i A');
    }

    /**
     * Example accessor: Return formatted updated date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->fooo_updated?->format('d M Y, h:i A');
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Example scope: Fetch records created today.
     */
    public function scopeCreatedToday($query)
    {
        return $query->whereDate('fooo_created', now()->toDateString());
    }
}
