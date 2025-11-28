<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\Label;
use App\Models\TaskActivity;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // -----------------------
    // SHOW ALL TASKS
    // -----------------------
    public function index(Request $request)
    {
        $projects = Project::all();

        $tasks = Task::orderBy('task_created', 'desc')
            ->when($request->project_id, function ($q) use ($request) {
                return $q->where('task_projectid', $request->project_id);
            })
            ->get();

        return view('tasks.index', compact('tasks', 'projects'));
    }

    // -----------------------
    // KANBAN PAGE  (FIX ADDED)
    // -----------------------
    public function kanban()
    {
        $tasks = Task::orderBy('task_created', 'desc')->get();

        $grouped = [
            'pending'      => $tasks->where('task_status', 'pending'),
            'in_progress'  => $tasks->where('task_status', 'in_progress'),
            'completed'    => $tasks->where('task_status', 'completed'),
            'cancelled'    => $tasks->where('task_status', 'cancelled'),
        ];

        return view('tasks.kanban', compact('grouped'));
    }

    // -----------------------
    // SHOW SINGLE TASK (FIX ADDED)
    // -----------------------
    public function show($id)
    {
        $task = Task::with([
            'subtasks',
            'comments.user',
            'files',
            'labels',
            'watchers',
            'activity.user'
        ])->findOrFail($id);

        return view('tasks.show', compact('task'));
    }

    // -----------------------
    // CREATE PAGE
    // -----------------------
    public function create()
    {
        $projects = Project::all();
        $users = User::all();
        $labels = Label::all();

        return view('tasks.create', compact('projects', 'users', 'labels'));
    }

    // -----------------------
    // STORE TASK
    // -----------------------
    public function store(Request $request)
    {
        $request->validate([
            'task_title' => 'required',
            'task_projectid' => 'required',
            'task_status' => 'required'
        ]);

        $task = Task::create([
            'task_title' => $request->task_title,
            'task_description' => $request->task_description,
            'task_projectid' => $request->task_projectid,
            'task_status' => $request->task_status,
            'task_priority' => $request->task_priority,
            'task_due_date' => $request->task_due_date,
            'task_creatorid' => auth()->id(),
        ]);

        if ($request->assigned_users) {
            $task->assignedUsers()->sync($request->assigned_users);
        }

        if ($request->labels) {
            $task->labels()->sync($request->labels);
        }

        $this->logActivity($task->task_id, 'Task created');

        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
    }

    // -----------------------
    // EDIT PAGE
    // -----------------------
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $projects = Project::all();
        $users = User::all();
        $labels = Label::all();

        return view('tasks.edit', compact('task', 'projects', 'users', 'labels'));
    }

    // -----------------------
    // UPDATE TASK
    // -----------------------
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $task->update([
            'task_title' => $request->task_title,
            'task_description' => $request->task_description,
            'task_projectid' => $request->task_projectid,
            'task_status' => $request->task_status,
            'task_priority' => $request->task_priority,
            'task_due_date' => $request->task_due_date
        ]);

        $task->assignedUsers()->sync($request->assigned_users ?? []);
        $task->labels()->sync($request->labels ?? []);

        $this->logActivity($id, 'Task updated');

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    // -----------------------
    // DELETE TASK
    // -----------------------
    public function destroy($id)
    {
        Task::findOrFail($id)->delete();

        $this->logActivity($id, 'Task deleted');

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }

    // -----------------------
    // KANBAN UPDATE
    // -----------------------
    public function kanbanUpdate(Request $request)
    {
        Task::where('task_id', $request->task_id)
            ->update(['task_status' => $request->status]);

        $this->logActivity($request->task_id, "Status changed to {$request->status}");

        return response()->json(['success' => true]);
    }

    // -----------------------
    // ACTIVITY LOG
    // -----------------------
    private function logActivity($task_id, $message)
    {
        TaskActivity::create([
            'task_id' => $task_id,
            'user_id' => auth()->id(),
            'message' => $message,
            'created_at' => now()
        ]);
    }
}
