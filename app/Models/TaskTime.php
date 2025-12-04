<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskTime extends Model
{
    protected $table = 'task_time';
    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'user_id',
        'start_time',
        'end_time',
        'total_minutes'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'task_id');
    }
}
