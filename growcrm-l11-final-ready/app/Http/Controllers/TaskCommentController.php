<?php

namespace App\Http\Controllers;

use App\Models\TaskComment;
use Illuminate\Http\Request;

class TaskCommentController extends Controller
{
    public function store(Request $request, $task_id)
    {
        $request->validate(['comment' => 'required']);

        TaskComment::create([
            'task_id' => $task_id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'created_at' => now()
        ]);

        return back();
    }
}
