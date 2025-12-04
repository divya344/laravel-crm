<?php

namespace App\Http\Controllers;

use App\Models\Task;

class TaskWatcherController extends Controller
{
    public function watch($task_id)
    {
        Task::findOrFail($task_id)->watchers()->syncWithoutDetaching([auth()->id()]);
        return back();
    }

    public function unwatch($task_id)
    {
        Task::findOrFail($task_id)->watchers()->detach(auth()->id());
        return back();
    }
}
