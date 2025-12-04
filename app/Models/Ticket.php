<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $primaryKey = 'ticket_id';

    /**
     * Allow mass assignment
     */
    protected $fillable = [
        'ticket_subject',
        'ticket_message',
        'ticket_status',
        'ticket_clientid',
        'ticket_projectid',
        'ticket_userid',   // creator
    ];

    /**
     * Use default Laravel timestamps (created_at / updated_at)
     * Because your migration uses:
     * $table->timestamps();
     */
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /** -----------------------------------------------
     * RELATIONSHIPS
     * ----------------------------------------------- */

    // Ticket creator
    public function creator()
    {
        return $this->belongsTo(User::class, 'ticket_userid', 'id');
    }

    // Project
    public function project()
    {
        return $this->belongsTo(Project::class, 'ticket_projectid', 'project_id');
    }

    // Client
    public function client()
    {
        return $this->belongsTo(Client::class, 'ticket_clientid', 'client_id');
    }

    /** -----------------------------------------------
     * ACCESSORS
     * ----------------------------------------------- */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->created_at?->format('d M Y, h:i A');
    }

    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->updated_at?->format('d M Y, h:i A');
    }

    /** -----------------------------------------------
     * SCOPES
     * ----------------------------------------------- */
    public function scopeOpen($query)
    {
        return $query->where('ticket_status', 'open');
    }

    public function scopeClosed($query)
    {
        return $query->where('ticket_status', 'closed');
    }

    public function scopeAssignedTo($query, int $userId)
    {
        return $query->where('ticket_userid', $userId);
    }
}
