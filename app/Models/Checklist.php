<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $primaryKey = 'checklist_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['checklist_id'];
    const CREATED_AT = 'checklist_created';
    const UPDATED_AT = 'checklist_updated';

    /**
     * Polymorphic Relationship
     * (Can belong to either a Lead or a Task)
     */
    public function checklistresource()
    {
        return $this->morphTo();
    }

    /**
     * Optional: User who created the checklist item
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'checklist_creatorid', 'id');
    }

    /**
     * Scope: Only completed checklist items
     */
    public function scopeCompleted($query)
    {
        return $query->where('checklist_status', 'completed');
    }

    /**
     * Scope: Only pending checklist items
     */
    public function scopePending($query)
    {
        return $query->where('checklist_status', '!=', 'completed');
    }
}
