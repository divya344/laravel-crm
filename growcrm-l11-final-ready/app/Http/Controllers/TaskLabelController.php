<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskLabelController extends Controller
{
    public function attach(Request $request, $task_id)
    {
        $task = Task::findOrFail($task_id);
        $task->labels()->syncWithoutDetaching($request->labels);

        return back();
    }

    public function detach($task_id, $label_id)
    {
        $task = Task::findOrFail($task_id);
        $task->labels()->detach($label_id);

        return back();
    }
}
