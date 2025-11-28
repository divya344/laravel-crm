<?php

namespace App\Http\Controllers;

use App\Models\TaskReminder;
use Illuminate\Http\Request;

class TaskReminderController extends Controller
{
    public function store(Request $request, $task_id)
    {
        $request->validate([
            'remind_at' => 'required|date'
        ]);

        TaskReminder::create([
            'task_id' => $task_id,
            'remind_at' => $request->remind_at,
            'sent' => false
        ]);

        return back()->with('success', 'Reminder set');
    }
}
