<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $primaryKey = 'attachment_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['attachment_id'];
    const CREATED_AT = 'attachment_created';
    const UPDATED_AT = 'attachment_updated';

    /**
     * The user who created the attachment.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'attachment_creatorid', 'id');
    }

    /**
     * Polymorphic relationship:
     * - Attachments can belong to comments, expenses, tickets, or ticket replies.
     */
    public function attachmentresource()
    {
        return $this->morphTo();
    }

    /**
     * Tags relationship:
     * - An attachment can have many tags (shared polymorphic tag system).
     */
    public function tags()
    {
        return $this->morphMany(Tag::class, 'tagresource');
    }
}
