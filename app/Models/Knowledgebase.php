<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Knowledgebase extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'knowledgebase';
    protected $primaryKey = 'knowledgebase_id';
    protected $guarded = ['knowledgebase_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'knowledgebase_created';
    const UPDATED_AT = 'knowledgebase_updated';

    protected $casts = [
        'knowledgebase_created' => 'datetime',
        'knowledgebase_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The category this article belongs to.
     */
    public function category()
    {
        return $this->belongsTo(KbCategory::class, 'knowledgebase_categoryid', 'kbcategory_id');
    }

    /**
     * The user who created this article.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'knowledgebase_creatorid', 'id');
    }

    /**
     * Tags associated with this article.
     */
    public function tags()
    {
        return $this->morphMany(Tag::class, 'tagresource');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->knowledgebase_created
            ? Carbon::parse($this->knowledgebase_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get formatted update date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->knowledgebase_updated
            ? Carbon::parse($this->knowledgebase_updated)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Generate a short article title (useful for dashboard cards).
     */
    public function getShortTitleAttribute(): string
    {
        return strlen($this->knowledgebase_title) > 50
            ? substr($this->knowledgebase_title, 0, 50) . '...'
            : $this->knowledgebase_title;
    }

    /**
     * Generate a short article excerpt (safe for display).
     */
    public function getExcerptAttribute(): string
    {
        $plain = strip_tags($this->knowledgebase_content ?? '');
        return strlen($plain) > 150
            ? substr($plain, 0, 150) . '...'
            : $plain;
    }

    /**
     * Get article status in a readable format.
     */
    public function getStatusLabelAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->knowledgebase_status ?? 'draft'));
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for published knowledgebase articles.
     */
    public function scopePublished($query)
    {
        return $query->where('knowledgebase_status', 'published');
    }

    /**
     * Scope for recently updated or added articles.
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('knowledgebase_created', '>=', now()->subDays($days));
    }

    /**
     * Scope for articles in a specific category.
     */
    public function scopeInCategory($query, int $categoryId)
    {
        return $query->where('knowledgebase_categoryid', $categoryId);
    }

    /** ─────────────── HELPERS ─────────────── */

    /**
     * Returns the URL-friendly slug for this article.
     */
    public function getSlugAttribute(): string
    {
        return str($this->knowledgebase_title)->slug('-');
    }

    /**
     * Returns the full public URL for this article.
     */
    public function getUrlAttribute(): string
    {
        return route('knowledgebase.show', ['id' => $this->knowledgebase_id, 'slug' => $this->slug]);
    }
}
