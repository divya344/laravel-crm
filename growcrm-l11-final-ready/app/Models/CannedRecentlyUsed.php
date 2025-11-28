<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CannedRecentlyUsed extends Model
{
    use HasFactory;

    protected $table = 'canned_recently_used';
    protected $primaryKey = 'cannedrecent_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['cannedrecent_id'];
    const CREATED_AT = 'cannedrecent_created';
    const UPDATED_AT = 'cannedrecent_updated';

    /**
     * Relationship: Recently used entry belongs to a Canned response
     */
    public function canned()
    {
        return $this->belongsTo(Canned::class, 'cannedrecent_cannedid', 'canned_id');
    }

    /**
     * Relationship: Recently used entry belongs to a User (who used it)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'cannedrecent_userid', 'id');
    }
}
