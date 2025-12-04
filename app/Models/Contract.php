<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Contract extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'contracts';
    protected $primaryKey = 'doc_id';
    protected $guarded = ['doc_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'doc_created';
    const UPDATED_AT = 'doc_updated';

    protected $casts = [
        'doc_created' => 'datetime',
        'doc_updated' => 'datetime',
        'doc_date_start' => 'datetime',
        'doc_date_end' => 'datetime',
        'doc_date_published' => 'datetime',
        'doc_date_last_emailed' => 'datetime',
        'doc_signed_date' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The user who created the contract.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'doc_creatorid', 'id');
    }

    /**
     * The category this contract belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'doc_categoryid', 'category_id');
    }

    /**
     * Tags related to this contract.
     */
    public function tags()
    {
        return $this->morphMany(Tag::class, 'tagresource');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Display formatted contract ID (with optional prefix).
     * Example: CNT-000012
     */
    public function getFormattedIdAttribute(): string
    {
        $prefix = config('app.contract_prefix', 'CNT');
        return sprintf('%s-%06d', $prefix, $this->doc_id);
    }

    /**
     * Helper to format date consistently.
     */
    protected function formatDate(?Carbon $date): ?string
    {
        return $date ? $date->format('d M Y, h:i A') : null;
    }

    public function getFormattedDocCreatedAttribute(): ?string
    {
        return $this->formatDate($this->doc_created);
    }

    public function getFormattedDocDateStartAttribute(): ?string
    {
        return $this->formatDate($this->doc_date_start);
    }

    public function getFormattedDocDateEndAttribute(): ?string
    {
        return $this->formatDate($this->doc_date_end);
    }

    public function getFormattedDocDatePublishedAttribute(): ?string
    {
        return $this->formatDate($this->doc_date_published);
    }

    public function getFormattedDocDateLastEmailedAttribute(): ?string
    {
        return $this->formatDate($this->doc_date_last_emailed);
    }

    public function getFormattedDocSignedDateAttribute(): ?string
    {
        return $this->formatDate($this->doc_signed_date);
    }

    /**
     * Full signer name (first + last).
     */
    public function getSignedFullNameAttribute(): ?string
    {
        $first = $this->doc_signed_first_name ?? '';
        $last = $this->doc_signed_last_name ?? '';
        $fullName = trim("$first $last");

        return $fullName !== '' ? $fullName : null;
    }

    /**
     * Human-readable contract status.
     */
    public function getLangDocStatusAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->doc_status ?? 'Unknown'));
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for active contracts.
     */
    public function scopeActive($query)
    {
        return $query->where('doc_status', 'active');
    }

    /**
     * Scope for expired contracts.
     */
    public function scopeExpired($query)
    {
        return $query->whereDate('doc_date_end', '<', now());
    }

    /**
     * Scope for signed contracts.
     */
    public function scopeSigned($query)
    {
        return $query->whereNotNull('doc_signed_date');
    }
}
