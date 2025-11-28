<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutomationAssigned extends Model
{
    use HasFactory;

    protected $table = 'automation_assigned';
    protected $primaryKey = 'automationassigned_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['automationassigned_id'];
    const CREATED_AT = 'automationassigned_created';
    const UPDATED_AT = 'automationassigned_updated';

    /**
     * Example: Relationship placeholders (if needed later)
     * Uncomment and adjust if automations/users are linked.
     */
    /*
    public function automation()
    {
        return $this->belongsTo(Automation::class, 'automationassigned_automationid', 'automation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'automationassigned_userid', 'id');
    }
    */
}
