<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assigned extends Model
{
    use HasFactory;

    protected $table = 'assigned';
    protected $primaryKey = 'assigned_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['assigned_id'];
    const CREATED_AT = 'assigned_created';
    const UPDATED_AT = 'assigned_updated';

    /**
     * Relationship:
     * - The assigned record belongs to the user who created it
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'assigned_creatorid', 'id');
    }

    /**
     * Polymorphic relationship:
     * - Assigned can belong to a project, task, lead, or webform
     */
    public function assignedresource()
    {
        return $this->morphTo();
    }
}
