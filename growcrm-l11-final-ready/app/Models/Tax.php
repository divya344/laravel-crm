<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Class Tag
 *
 * Represents a polymorphic tag that can be attached to multiple model types.
 *
 * @property int $tag_id
 * @property string $tag_name
 * @property string|null $tag_color
 * @property string|null $tag_type
 * @property int|null $tag_creatorid
 * @property string|null $tagresource_type
 * @property int|null $tagresource_id
 * @property \Carbon\Carbon|null $tag_created
 * @property \Carbon\Carbon|null $tag_updated
 */
class Tax extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'tags';
    protected $primaryKey = 'tag_id';
    protected $guarded = ['tag_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'tag_created';
    const UPDATED_AT = 'tag_updated';

    protected $casts = [
        'tag_created' => 'datetime',
        'tag_updated' => 'datetime',
    ];

    /** ─────────────── POLYMORPHIC MAP ─────────────── */
    public static function booted(): void
    {
        Relation::morphMap([
            'invoice' => \App\Models\Invoice::class,
            'project' => \App\Models\Project::class,
            'client' => \App\Models\Client::class,
            'lead' => \App\Models\Lead::class,
            'task' => \App\Models\Task::class,
            'estimate' => \App\Models\Estimate::class,
            'ticket' => \App\Models\Ticket::class,
            'contract' => \App\Models\Contract::class,
            'note' => \App\Models\Note::class,
            'file' => \App\Models\File::class,
            'attachment' => \App\Models\Attachment::class,
        ]);
    }

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The user who created this tag.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tag_creatorid', 'id');
    }

    /**
     * The model (invoice, project, etc.) this tag belongs to.
     */
    public function tagresource(): MorphTo
    {
        return $this->morphTo();
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get a formatted name for UI display.
     */
    public function getDisplayNameAttribute(): string
    {
        return ucfirst($this->tag_name);
    }

    /**
     * Get formatted creation date for UI display.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->tag_created?->format('d M Y, h:i A');
    }

    /**
     * Get formatted update date for UI display.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->tag_updated?->format('d M Y, h:i A');
    }
}
