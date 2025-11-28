<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskAssigned extends Model
{
    protected $table = 'task_assigned';
    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'user_id'
    ];
}
