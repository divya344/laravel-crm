<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Task;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    public function store(Request $request, $task_id)
    {
        $request->validate(['title' => 'required']);

        Subtask::create([
            'task_id' => $task_id,
            'title' => $request->title
        ]);

        return back()->with('success', 'Subtask added');
    }

    public function toggle($id)
    {
        $sub = Subtask::findOrFail($id);
        $sub->completed = !$sub->completed;
        $sub->save();

        return back();
    }
}
