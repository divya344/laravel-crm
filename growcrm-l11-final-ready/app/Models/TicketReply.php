<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TicketReply extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'ticket_replies';
    protected $primaryKey = 'ticketreply_id';
    protected $guarded = ['ticketreply_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'ticketreply_created';
    const UPDATED_AT = 'ticketreply_updated';

    protected $casts = [
        'ticketreply_created' => 'datetime',
        'ticketreply_updated' => 'datetime',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The user who created this reply.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'ticketreply_creatorid', 'id');
    }

    /**
     * The ticket that this reply belongs to.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticketreply_ticketid', 'ticket_id');
    }

    /**
     * Attachments related to this reply.
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentresource');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Get formatted creation date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->ticketreply_created
            ? Carbon::parse($this->ticketreply_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get formatted update date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->ticketreply_updated
            ? Carbon::parse($this->ticketreply_updated)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Get a short preview of the reply message (for table/list view).
     */
    public function getShortMessageAttribute(): string
    {
        return \Str::limit(strip_tags($this->ticketreply_text ?? ''), 80, '...');
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope: Replies created by a specific user.
     */
    public function scopeByCreator($query, int $userId)
    {
        return $query->where('ticketreply_creatorid', $userId);
    }

    /**
     * Scope: Replies belonging to a specific ticket.
     */
    public function scopeForTicket($query, int $ticketId)
    {
        return $query->where('ticketreply_ticketid', $ticketId);
    }
}
