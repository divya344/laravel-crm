<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Estimate extends Model
{
    use HasFactory;

    /** ─────────────── TABLE CONFIG ─────────────── */
    protected $table = 'estimates';
    protected $primaryKey = 'bill_estimateid'; // ✅ actual column name
    public $incrementing = true;
    public $timestamps = false; // ✅ because we use custom timestamp columns

    /** ─────────────── FILLABLE FIELDS ─────────────── */
    protected $fillable = [
        'estimate_number',
        'client_name',
        'bill_amount',
        'bill_status',
        'bill_date',
        'bill_expiry_date',
        'bill_notes',
        'bill_created',
        'bill_updated',
    ];

    /** ─────────────── ROUTE BINDING FIX ─────────────── */
    public function getRouteKeyName()
    {
        return 'bill_estimateid';
    }

    /** ─────────────── ACCESSORS ─────────────── */

    // Format the amount for display
    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format($this->bill_amount ?? 0, 2);
    }

    // Format created date
    public function getFormattedCreatedAttribute(): string
    {
        return $this->bill_created
            ? Carbon::parse($this->bill_created)->format('d M Y')
            : '—';
    }

    // Get readable status with color logic
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->bill_status) {
            'approved' => 'bg-success',
            'rejected' => 'bg-danger',
            'sent' => 'bg-info',
            'draft' => 'bg-secondary',
            default => 'bg-secondary',
        };
    }
}
