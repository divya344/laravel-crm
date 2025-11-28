<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected $table = 'blocks';
    protected $primaryKey = 'block_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['block_id'];
    const CREATED_AT = 'block_created';
    const UPDATED_AT = 'block_updated';

    /**
     * Example relationship (if needed later)
     * Uncomment when blocks belong to a page, dashboard, or user.
     */
    /*
    public function dashboard()
    {
        return $this->belongsTo(Dashboard::class, 'block_dashboard_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'block_creatorid', 'id');
    }
    */
}
