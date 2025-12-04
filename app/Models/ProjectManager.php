<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * ProjectManager Model
 *
 * Represents users who are assigned as managers for specific projects.
 */
class ProjectManager extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'projects_manager';
    protected $primaryKey = 'projectsmanager_id';
    protected $guarded = ['projectsmanager_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'projectsmanager_created';
    const UPDATED_AT = 'projectsmanager_updated';

    protected $casts = [
        'projectsmanager_created' => 'datetime',
        'projectsmanager_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The project that this manager is assigned to.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'projectsmanager_projectid', 'project_id');
    }

    /**
     * The user who is assigned as the project manager.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'projectsmanager_userid', 'id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Formatted "created" timestamp.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->projectsmanager_created
            ? Carbon::parse($this->projectsmanager_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Formatted "updated" timestamp.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->projectsmanager_updated
            ? Carbon::parse($this->projectsmanager_updated)->format('d M Y, h:i A')
            : null;
    }
}
