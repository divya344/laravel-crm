<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    'project' => \App\Models\Project::class,
    'task' => \App\Models\Task::class,
    'ticket' => \App\Models\Ticket::class,
]);

class Comment extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'comments';
    protected $primaryKey = 'comment_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['comment_id'];

    const CREATED_AT = 'comment_created';
    const UPDATED_AT = 'comment_updated';

    protected $casts = [
        'comment_created' => 'datetime',
        'comment_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * Each comment is created by one user.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'comment_creatorid', 'id');
    }

    /**
     * A comment belongs to a polymorphic model (project, task, or ticket).
     */
    public function commentable()
    {
        // renamed from 'commentresource' → more intuitive Laravel naming
        return $this->morphTo();
    }

    /**
     * Each comment can have multiple attachments.
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentresource');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted date for display.
     */
    public function getFormattedCreatedAttribute()
    {
        return $this->comment_created?->format('d M Y, h:i A');
    }

    /** ─────────────── HELPERS ─────────────── */

    /**
     * Returns a short version of comment text for previews.
     */
    public function getExcerptAttribute()
    {
        return strlen($this->comment_text ?? '') > 80
            ? substr($this->comment_text, 0, 80) . '...'
            : $this->comment_text;
    }
}
