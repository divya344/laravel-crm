<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class kbcategories extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'kb_categories';
    protected $primaryKey = 'kbcategory_id';
    protected $guarded = ['kbcategory_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'kbcategory_created';
    const UPDATED_AT = 'kbcategory_updated';

    protected $casts = [
        'kbcategory_created' => 'datetime',
        'kbcategory_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * A KB Category can have many articles (knowledgebase entries).
     */
    public function articles()
    {
        return $this->hasMany(Knowledgebase::class, 'knowledgebase_categoryid', 'kbcategory_id');
    }

    /**
     * The user who created this KB Category.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'kbcategory_creatorid', 'id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->kbcategory_created
            ? Carbon::parse($this->kbcategory_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get formatted update date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->kbcategory_updated
            ? Carbon::parse($this->kbcategory_updated)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get the number of articles in this category.
     */
    public function getArticlesCountAttribute(): int
    {
        return $this->articles()->count();
    }

    /**
     * Get a short name version (useful for navigation).
     */
    public function getShortNameAttribute(): string
    {
        return strlen($this->kbcategory_name) > 20
            ? substr($this->kbcategory_name, 0, 20) . '...'
            : $this->kbcategory_name;
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope: Only active KB categories.
     */
    public function scopeActive($query)
    {
        return $query->where('kbcategory_status', 'active');
    }

    /**
     * Scope: Recently created KB categories.
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('kbcategory_created', '>=', now()->subDays($days));
    }

    /** ─────────────── HELPERS ─────────────── */

    /**
     * Get formatted category summary with article count.
     */
    public function getSummaryAttribute(): string
    {
        return sprintf(
            '%s (%d articles)',
            $this->kbcategory_name ?? 'Untitled Category',
            $this->articles_count
        );
    }
}
