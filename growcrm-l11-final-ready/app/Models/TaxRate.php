<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TaxRate extends Model
{
    use HasFactory;

    /**
     * Table configuration
     */
    protected $table = 'taxrates';
    protected $primaryKey = 'taxrate_id';
    protected $guarded = ['taxrate_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'taxrate_created';
    const UPDATED_AT = 'taxrate_updated';

    /**
     * Attribute casting
     */
    protected $casts = [
        'taxrate_created' => 'datetime',
        'taxrate_updated' => 'datetime',
    ];

    /**
     * Get a human-readable created date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->taxrate_created
            ? Carbon::parse($this->taxrate_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get a human-readable updated date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->taxrate_updated
            ? Carbon::parse($this->taxrate_updated)->format('d M Y, h:i A')
            : null;
    }
}
