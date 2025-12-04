<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Item extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'items';
    protected $primaryKey = 'item_id';
    protected $guarded = ['item_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'item_created';
    const UPDATED_AT = 'item_updated';

    protected $casts = [
        'item_created' => 'datetime',
        'item_updated' => 'datetime',
        'item_price'   => 'decimal:2',
        'item_quantity' => 'integer',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The user who created this item.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'item_creatorid', 'id');
    }

    /**
     * The category this item belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'item_categoryid', 'category_id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get the encoded estimation notes (for safe HTML rendering).
     */
    public function getEstimationNotesEncodedAttribute(): ?string
    {
        return $this->item_notes_estimation
            ? e($this->item_notes_estimation)
            : null;
    }

    /**
     * Check whether the item has estimation notes.
     */
    public function getHasEstimationNotesAttribute(): bool
    {
        return !empty($this->item_notes_estimation);
    }

    /**
     * Get formatted item price (with currency symbol).
     */
    public function getFormattedPriceAttribute(): string
    {
        $symbol = config('app.currency_symbol', '₹');
        return $symbol . number_format($this->item_price ?? 0, 2);
    }

    /**
     * Get total cost (price × quantity).
     */
    public function getTotalAmountAttribute(): float
    {
        return ($this->item_price ?? 0) * ($this->item_quantity ?? 1);
    }

    /**
     * Get formatted total amount.
     */
    public function getFormattedTotalAmountAttribute(): string
    {
        $symbol = config('app.currency_symbol', '₹');
        return $symbol . number_format($this->total_amount, 2);
    }

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->item_created
            ? Carbon::parse($this->item_created)->format('d M Y, h:i A')
            : null;
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope: Only active items.
     */
    public function scopeActive($query)
    {
        return $query->where('item_status', 'active');
    }

    /**
     * Scope: Items created by a specific user.
     */
    public function scopeCreatedBy($query, int $userId)
    {
        return $query->where('item_creatorid', $userId);
    }

    /**
     * Scope: Recently created items (last X days).
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('item_created', '>=', now()->subDays($days));
    }

    /** ─────────────── HELPERS ─────────────── */

    /**
     * Generate a short summary string (for dropdowns, tables, etc.).
     */
    public function getSummaryAttribute(): string
    {
        return sprintf(
            '%s — Qty: %d, %s each',
            $this->item_name ?? 'Unnamed Item',
            $this->item_quantity ?? 1,
            $this->formatted_price
        );
    }
}
