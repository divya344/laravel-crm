<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskReminder extends Model
{
    protected $table = 'task_reminders';
    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'remind_at',
        'sent'
    ];
}
