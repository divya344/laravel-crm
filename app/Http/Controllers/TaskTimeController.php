<?php

namespace App\Http\Controllers;

use App\Models\TaskTime;
use Illuminate\Http\Request;

class TaskTimeController extends Controller
{
    public function start($task_id)
    {
        TaskTime::create([
            'task_id' => $task_id,
            'user_id' => auth()->id(),
            'start_time' => now()
        ]);

        return back();
    }

    public function stop($task_id)
    {
        $timer = TaskTime::where('task_id', $task_id)
            ->where('user_id', auth()->id())
            ->whereNull('end_time')
            ->first();

        if ($timer) {
            $minutes = now()->diffInMinutes($timer->start_time);

            $timer->update([
                'end_time' => now(),
                'total_minutes' => $minutes
            ]);
        }

        return back();
    }
}
