<?php

namespace App\Http\Controllers;

use App\Models\TaskFile;
use Illuminate\Http\Request;

class TaskFileController extends Controller
{
    public function store(Request $request, $task_id)
    {
        $request->validate([
            'file' => 'required|file|max:50000'
        ]);

        $file = $request->file('file');
        $path = $file->store('task_files', 'public');

        TaskFile::create([
            'task_id' => $task_id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'uploaded_at' => now()
        ]);

        return back();
    }
}
