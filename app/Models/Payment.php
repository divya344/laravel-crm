<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payment extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';
    protected $dateFormat = 'Y-m-d H:i:s';

    // Custom timestamps (CRM style)
    const CREATED_AT = 'payment_created';
    const UPDATED_AT = 'payment_updated';

    protected $fillable = [
        'payment_reference',
        'payment_clientid',
        'payment_invoiceid',
        'payment_projectid',
        'payment_creatorid',
        'payment_method',
        'payment_amount',
        'payment_status',
        'payment_date',
        'payment_notes',
        'payment_created',
        'payment_updated',
    ];

    protected $casts = [
        'payment_created' => 'datetime',
        'payment_updated' => 'datetime',
        'payment_date'    => 'datetime',
        'payment_amount'  => 'decimal:2',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * User who created the payment.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'payment_creatorid', 'id');
    }

    /**
     * Related invoice.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'payment_invoiceid', 'bill_invoiceid');
    }

    /**
     * Related client.
     * ✔ FIXED: Your clients table uses client_id (NOT id)
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'payment_clientid', 'client_id');
    }

    /**
     * Related project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'payment_projectid', 'project_id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    public function getFormattedInvoiceIdAttribute(): string
    {
        $prefix = config('app.invoice_prefix', 'INV');
        return sprintf('%s-%06d', $prefix, $this->payment_invoiceid);
    }

    public function getFormattedPaymentDateAttribute(): ?string
    {
        return $this->payment_date
            ? Carbon::parse($this->payment_date)->format('d M Y, h:i A')
            : null;
    }

    public function getFormattedAmountAttribute(): string
    {
        $symbol = config('app.currency_symbol', '₹');
        return $symbol . number_format($this->payment_amount ?? 0, 2);
    }

    public function getLangPaymentStatusAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->payment_status ?? 'pending'));
    }

    public function getFormattedReferenceAttribute(): string
    {
        return $this->payment_reference ?? 'N/A';
    }

    /** ─────────────── SCOPES ─────────────── */

    public function scopeCompleted($query)
    {
        return $query->where('payment_status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeForClient($query, int $clientId)
    {
        return $query->where('payment_clientid', $clientId);
    }

    public function scopeForInvoice($query, int $invoiceId)
    {
        return $query->where('payment_invoiceid', $invoiceId);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('payment_created', '>=', now()->subDays($days));
    }
}
