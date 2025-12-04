<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $primaryKey = 'task_id';
    public $timestamps = false;

    protected $fillable = [
        'task_title',
        'task_description',
        'task_projectid',
        'task_creatorid',
        'task_status',
        'task_priority',
        'task_due_date',
        'task_created',
        'task_updated'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($task) {
            $task->task_created = now();
            $task->task_updated = now();
            $task->task_creatorid = auth()->id();
        });

        static::updating(function ($task) {
            $task->task_updated = now();
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'task_projectid', 'project_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'task_creatorid', 'id');
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class, 'task_id', 'task_id');
    }

    public function files()
    {
        return $this->hasMany(TaskFile::class, 'task_id', 'task_id');
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class, 'task_id', 'task_id');
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'task_assigned', 'task_id', 'user_id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'task_label_map', 'task_id', 'label_id');
    }

    public function watchers()
    {
        return $this->belongsToMany(User::class, 'task_watchers', 'task_id', 'user_id');
    }

    public function times()
    {
        return $this->hasMany(TaskTime::class, 'task_id', 'task_id');
    }

    public function activity()
    {
        return $this->hasMany(TaskActivity::class, 'task_id', 'task_id');
    }
}
