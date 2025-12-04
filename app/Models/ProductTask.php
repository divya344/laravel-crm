<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * ProductTask Model
 *
 * Represents tasks related to a product, such as production steps or deliverables.
 */
class ProductTask extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'product_tasks';
    protected $primaryKey = 'product_task_id';
    protected $guarded = ['product_task_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'product_task_created';
    const UPDATED_AT = 'product_task_updated';

    protected $casts = [
        'product_task_created' => 'datetime',
        'product_task_updated' => 'datetime',
    ];

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted created date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->product_task_created
            ? Carbon::parse($this->product_task_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get formatted updated date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->product_task_updated
            ? Carbon::parse($this->product_task_updated)->format('d M Y, h:i A')
            : null;
    }
}
