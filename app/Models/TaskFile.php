<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskFile extends Model
{
    protected $table = 'task_files';
    protected $primaryKey = 'file_id';
    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'file_name',
        'file_path',
        'uploaded_at'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'task_id');
    }
}
