<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    protected $table = 'subtasks';
    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'title',
        'completed'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'task_id');
    }
}
