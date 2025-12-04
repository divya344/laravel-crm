<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * ProjectAssigned Model
 *
 * Represents a record linking users assigned to projects.
 */
class ProjectAssigned extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'projects_assigned';
    protected $primaryKey = 'projectsassigned_id';
    protected $guarded = ['projectsassigned_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'projectsassigned_created';
    const UPDATED_AT = 'projectsassigned_updated';

    protected $casts = [
        'projectsassigned_created' => 'datetime',
        'projectsassigned_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The project this assignment belongs to.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'projectsassigned_projectid', 'project_id');
    }

    /**
     * The user who is assigned to the project.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'projectsassigned_userid', 'id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get a formatted "created" timestamp.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->projectsassigned_created
            ? Carbon::parse($this->projectsassigned_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get a formatted "updated" timestamp.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->projectsassigned_updated
            ? Carbon::parse($this->projectsassigned_updated)->format('d M Y, h:i A')
            : null;
    }
}
