<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    protected $table = 'task_comments';
    protected $primaryKey = 'comment_id';
    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'user_id',
        'comment',
        'created_at'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
