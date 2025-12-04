<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * MessagesTracking Model
 *
 * Tracks message-related activities such as delivery, read receipts, and status updates.
 */
class MessagesTracking extends Model
{
    use HasFactory;

    /** ─────────────── MODEL CONFIG ─────────────── */
    protected $table = 'messages_tracking';
    protected $primaryKey = 'messagestracking_id';
    protected $guarded = ['messagestracking_id'];
    protected $dateFormat = 'Y-m-d H:i:s';

    const CREATED_AT = 'messagestracking_created';
    const UPDATED_AT = 'messagestracking_updated';

    protected $casts = [
        'messagestracking_created' => 'datetime',
        'messagestracking_updated' => 'datetime',
        'is_read' => 'boolean',
        'is_delivered' => 'boolean',
    ];

    /** ─────────────── RELATIONSHIPS ─────────────── */

    /**
     * The message this tracking record belongs to.
     */
    public function message()
    {
        return $this->belongsTo(Message::class, 'messagestracking_messageid', 'message_id');
    }

    /**
     * The user this tracking entry is related to (e.g., recipient or reader).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'messagestracking_userid', 'id');
    }

    /** ─────────────── ACCESSORS ─────────────── */

    /**
     * Formatted created date.
     */
    public function getFormattedCreatedAttribute(): ?string
    {
        return $this->messagestracking_created
            ? Carbon::parse($this->messagestracking_created)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Formatted updated date.
     */
    public function getFormattedUpdatedAttribute(): ?string
    {
        return $this->messagestracking_updated
            ? Carbon::parse($this->messagestracking_updated)->format('d M Y, h:i A')
            : null;
    }

    /**
     * Human-readable delivery status.
     */
    public function getDeliveryStatusAttribute(): string
    {
        if ($this->is_read) {
            return 'Read';
        }
        if ($this->is_delivered) {
            return 'Delivered';
        }
        return 'Pending';
    }

    /** ─────────────── SCOPES ─────────────── */

    /**
     * Scope for unread message trackings.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for delivered messages.
     */
    public function scopeDelivered($query)
    {
        return $query->where('is_delivered', true);
    }

    /**
     * Scope for a specific user.
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('messagestracking_userid', $userId);
    }

    /**
     * Scope for a specific message.
     */
    public function scopeForMessage($query, int $messageId)
    {
        return $query->where('messagestracking_messageid', $messageId);
    }

    /** ─────────────── HELPERS ─────────────── */

    /**
     * Mark the message as delivered.
     */
    public function markAsDelivered(): void
    {
        $this->update(['is_delivered' => true]);
    }

    /**
     * Mark the message as read.
     */
    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }
}
