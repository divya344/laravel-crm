<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Carbon\Carbon;

/**
 * Note Model
 *
 * Represents a note that can belong to different resources (Project, Client, User, Lead).
 * Supports polymorphic relationships for flexible note assignments.
 */
Relation::morphMap([
    'project' => Project::class,
    'client'  => Client::class,
    'user'    => User::class,
    'lead'    => Lead::class,
]);

class Note extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'notes';
    protected $primaryKey = 'note_id';
    protected $guarded = ['note_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'note_created';
    const UPDATED_AT = 'note_updated';

    protected $casts = [
        'note_created' => 'datetime',
        'note_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The user who created this note.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'note_creatorid', 'id');
    }

    /**
     * The resource (Project, Client, Lead, etc.) this note belongs to.
     * Uses Laravel’s polymorphic relationship.
     */
    public function noteresource()
    {
        return $this->morphTo();
    }

    /**
     * Tags associated with this note.
     */
    public function tags()
    {
        return $this->morphMany(Tag::class, 'tagresource');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Return a formatted created date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->note_created
            ? Carbon::parse($this->note_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Return a formatted updated date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->note_updated
            ? Carbon::parse($this->note_updated)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get a preview of the note content (truncated text).
     */
    public function getShortContentAttribute(): string
    {
        return strlen($this->note_text ?? '') > 50
            ? substr($this->note_text, 0, 50) . '...'
            : ($this->note_text ?? '');
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for filtering notes by creator.
     */
    public function scopeByCreator($query, int $userId)
    {
        return $query->where('note_creatorid', $userId);
    }

    /**
     * Scope for filtering notes created within the last X days.
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('note_created', '>=', now()->subDays($days));
    }

    /**
     * Scope for notes belonging to a specific resource type (e.g., project).
     */
    public function scopeForResource($query, string $type, int $id)
    {
        return $query->where('noteresource_type', $type)
                     ->where('noteresource_id', $id);
    }
}
