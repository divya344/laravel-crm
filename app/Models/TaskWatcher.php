<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskWatcher extends Model
{
    protected $table = 'task_watchers';
    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'user_id'
    ];
}
