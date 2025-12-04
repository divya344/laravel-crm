<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Carbon\Carbon;

/**
 * LineItem Model
 * Represents individual line items (invoice/estimate items).
 */
Relation::morphMap([
    'invoice' => Invoice::class,
    'estimate' => Estimate::class,
]);

class LineItem extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'lineitems';
    protected $primaryKey = 'lineitem_id';
    protected $guarded = ['lineitem_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'lineitem_created';
    const UPDATED_AT = 'lineitem_updated';

    protected $casts = [
        'lineitem_created' => 'datetime',
        'lineitem_updated' => 'datetime',
        'lineitem_rate' => 'float',
        'lineitem_quantity' => 'float',
        'lineitem_total' => 'float',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * Polymorphic relationship: line item belongs to either invoice or estimate.
     */
    public function lineitemresource()
    {
        return $this->morphTo();
    }

    /**
     * Taxes associated with this line item.
     */
    public function taxes()
    {
        return $this->hasMany(Tax::class, 'tax_lineitem_id', 'lineitem_id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted rate.
     */
    public function getFormattedRateAttribute(): string
    {
        return number_format($this->lineitem_rate ?? 0, 2);
    }

    /**
     * Get formatted quantity.
     */
    public function getFormattedQuantityAttribute(): string
    {
        return number_format($this->lineitem_quantity ?? 0, 2);
    }

    /**
     * Get formatted total.
     */
    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->lineitem_total ?? 0, 2);
    }

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->lineitem_created
            ? Carbon::parse($this->lineitem_created)->format('d M Y, h:i A')
            : null;
    }

    /** ─────────────── HELPERS ─────────────── */

    /**
     * Calculate subtotal for the line item (rate × quantity).
     */
    public function getSubtotalAttribute(): float
    {
        return ($this->lineitem_rate ?? 0) * ($this->lineitem_quantity ?? 0);
    }

    /**
     * Calculate total tax applied to this line item.
     */
    public function getTotalTaxAmountAttribute(): float
    {
        return $this->taxes->sum('tax_amount');
    }

    /**
     * Calculate total amount including tax.
     */
    public function getGrandTotalAttribute(): float
    {
        return $this->subtotal + $this->total_tax_amount;
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for line items belonging to invoices.
     */
    public function scopeForInvoices($query)
    {
        return $query->where('lineitemresource_type', Invoice::class);
    }

    /**
     * Scope for line items belonging to estimates.
     */
    public function scopeForEstimates($query)
    {
        return $query->where('lineitemresource_type', Estimate::class);
    }
}
