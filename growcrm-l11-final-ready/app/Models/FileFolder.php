<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class FileFolder extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'file_folders';
    protected $primaryKey = 'filefolder_id';
    protected $guarded = ['filefolder_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'filefolder_created';
    const UPDATED_AT = 'filefolder_updated';

    protected $casts = [
        'filefolder_created' => 'datetime',
        'filefolder_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The user who created this folder.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'filefolder_creatorid', 'id');
    }

    /**
     * Files that belong to this folder.
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class, 'file_folderid', 'filefolder_id');
    }

    /**
     * Subfolders inside this folder (if hierarchical).
     */
    public function subfolders(): HasMany
    {
        return $this->hasMany(FileFolder::class, 'filefolder_parentid', 'filefolder_id');
    }

    /**
     * Parent folder (if nested).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(FileFolder::class, 'filefolder_parentid', 'filefolder_id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->filefolder_created
            ? $this->filefolder_created->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get formatted update date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->filefolder_updated
            ? $this->filefolder_updated->format('d M Y, h:i A')
            : null;
    }

    /**
     * Count of files in this folder.
     */
    public function getFileCountAttribute(): int
    {
        return $this->files()->count();
    }

    /**
     * Check if folder has subfolders.
     */
    public function getHasSubfoldersAttribute(): bool
    {
        return $this->subfolders()->exists();
    }

    /**
     * Display-friendly folder name (fallback if empty).
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->filefolder_name ?: 'Unnamed Folder';
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope: Top-level folders only.
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('filefolder_parentid');
    }

    /**
     * Scope: Folders created by a specific user.
     */
    public function scopeCreatedBy($query, int $userId)
    {
        return $query->where('filefolder_creatorid', $userId);
    }

    /**
     * Scope: Recently created folders (last X days).
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('filefolder_created', '>=', now()->subDays($days));
    }

    /** ─────────────── HELPERS ─────────────── */

    /**
     * Folder path (useful for breadcrumb navigation).
     */
    public function getFolderPathAttribute(): string
    {
        $path = [$this->filefolder_name];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($path, $parent->filefolder_name);
            $parent = $parent->parent;
        }

        return implode(' / ', $path);
    }
}
