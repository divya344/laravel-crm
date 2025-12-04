<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

// Define morph map for clarity
Relation::morphMap([
    'project' => \App\Models\Project::class,
    'client' => \App\Models\Client::class,
]);

class File extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'files';
    protected $primaryKey = 'file_id';
    protected $guarded = ['file_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'file_created';
    const UPDATED_AT = 'file_updated';

    protected $casts = [
        'file_created' => 'datetime',
        'file_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * Parent resource (Project, Client, etc.)
     */
    public function fileresource(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * The user who uploaded the file.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'file_creatorid', 'id');
    }

    /**
     * Tags attached to the file.
     */
    public function tags(): MorphMany
    {
        return $this->morphMany(Tag::class, 'tagresource');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get the full file URL (supports public and S3).
     */
    public function getUrlAttribute(): ?string
    {
        return $this->file_path
            ? Storage::url($this->file_path)
            : null;
    }

    /**
     * Get formatted file size (in KB, MB, GB).
     */
    public function getReadableSizeAttribute(): string
    {
        $size = $this->file_size ?? 0;
        if ($size >= 1073741824) {
            return round($size / 1073741824, 2) . ' GB';
        } elseif ($size >= 1048576) {
            return round($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return round($size / 1024, 2) . ' KB';
        } else {
            return "{$size} B";
        }
    }

    /**
     * Get formatted upload date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->file_created
            ? $this->file_created->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get file extension (e.g., 'pdf', 'jpg').
     */
    public function getExtensionAttribute(): ?string
    {
        return pathinfo($this->file_name ?? '', PATHINFO_EXTENSION);
    }

    /**
     * Get icon class for file type (Bootstrap Icons or similar).
     */
    public function getIconAttribute(): string
    {
        $ext = strtolower($this->extension ?? '');
        return match ($ext) {
            'jpg', 'jpeg', 'png', 'gif' => 'bi bi-image',
            'pdf' => 'bi bi-file-earmark-pdf',
            'doc', 'docx' => 'bi bi-file-earmark-word',
            'xls', 'xlsx' => 'bi bi-file-earmark-excel',
            'zip', 'rar' => 'bi bi-file-earmark-zip',
            'mp4', 'avi', 'mov' => 'bi bi-file-earmark-play',
            'mp3', 'wav' => 'bi bi-file-earmark-music',
            default => 'bi bi-file-earmark',
        };
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope: Filter by creator.
     */
    public function scopeCreatedBy($query, int $userId)
    {
        return $query->where('file_creatorid', $userId);
    }

    /**
     * Scope: Filter by type (e.g., 'project', 'client').
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('fileresource_type', $type);
    }

    /**
     * Scope: Filter recent files (last X days).
     */
    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('file_created', '>=', now()->subDays($days));
    }

    /**
     * Scope: Filter files by extension.
     */
    public function scopeWithExtension($query, string $ext)
    {
        return $query->where('file_name', 'like', "%.$ext");
    }

    /** ─────────────── HELPERS ─────────────── */

    /**
     * Check if file is an image.
     */
    public function getIsImageAttribute(): bool
    {
        return in_array(strtolower($this->extension ?? ''), ['jpg', 'jpeg', 'png', 'gif']);
    }

    /**
     * Check if file is downloadable.
     */
    public function getIsDownloadableAttribute(): bool
    {
        return !empty($this->file_path);
    }
}
