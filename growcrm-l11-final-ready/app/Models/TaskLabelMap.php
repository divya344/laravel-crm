<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLabelMap extends Model
{
    protected $table = 'task_label_map';
    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'label_id'
    ];
}
