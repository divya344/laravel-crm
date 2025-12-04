@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3">Tasks</h3>

    <div class="mb-3">
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ New Task</a>
        <a href="{{ url('tasks/kanban') }}" class="btn btn-secondary">Kanban View</a>
    </div>

    <form method="GET" class="mb-3">
        <select name="project_id" class="form-select" onchange="this.form.submit()">
            <option value="">Filter by Project</option>
            @foreach($projects as $p)
                <option value="{{ $p->project_id }}" 
                    {{ request('project_id') == $p->project_id ? 'selected' : '' }}>
                    {{ $p->project_title }}
                </option>
            @endforeach
        </select>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Task</th>
                <th>Project</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Due</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->task_title }}</td>
                <td>{{ $task->project->project_title ?? '-' }}</td>

                <td>
                    <span class="badge bg-info">{{ $task->task_status }}</span>
                </td>

                <td>
                    <span class="badge 
                        @if($task->task_priority=='high') bg-danger 
                        @elseif($task->task_priority=='medium') bg-warning 
                        @else bg-success @endif ">
                        {{ $task->task_priority }}
                    </span>
                </td>

                <td>{{ $task->task_due_date ?? '-' }}</td>

                <td>
                    <a href="{{ route('tasks.edit', $task->task_id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form method="POST" action="{{ route('tasks.destroy',$task->task_id) }}" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete task?')">Delete</button>
                    </form>

                    <a href="{{ route('tasks.show',$task->task_id) }}" class="btn btn-sm btn-secondary">View</a>
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

</div>
@endsection
