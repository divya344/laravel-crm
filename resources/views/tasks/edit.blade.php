@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Edit Task</h3>

    <form action="{{ route('tasks.update',$task->task_id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="task_title" class="form-control" value="{{ $task->task_title }}">
        </div>

        <div class="mb-3">
            <label>Project</label>
            <select name="task_projectid" class="form-select">
                @foreach($projects as $p)
                    <option value="{{ $p->project_id }}" 
                        {{ $task->task_projectid == $p->project_id ? 'selected':'' }}>
                        {{ $p->project_title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="task_description" class="form-control">{{ $task->task_description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="task_status" class="form-select">
                <option value="pending" {{ $task->task_status=='pending'?'selected':'' }}>Pending</option>
                <option value="in_progress" {{ $task->task_status=='in_progress'?'selected':'' }}>In Progress</option>
                <option value="completed" {{ $task->task_status=='completed'?'selected':'' }}>Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Priority</label>
            <select name="task_priority" class="form-select">
                <option value="low" {{ $task->task_priority=='low'?'selected':'' }}>Low</option>
                <option value="medium" {{ $task->task_priority=='medium'?'selected':'' }}>Medium</option>
                <option value="high" {{ $task->task_priority=='high'?'selected':'' }}>High</option>
            </select>
        </div>

        <!-- Assigned Users -->
        <div class="mb-3">
            <label>Assign Users</label>
            <select name="assigned_users[]" multiple class="form-select">
                @foreach($users as $u)
                    <option value="{{ $u->id }}"
                        {{ $task->assignedUsers->contains($u->id) ? 'selected':'' }}>
                        {{ $u->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Labels -->
        <div class="mb-3">
            <label>Labels</label>
            <select name="labels[]" multiple class="form-select">
                @foreach($labels as $l)
                    <option value="{{ $l->id }}" 
                        {{ $task->labels->contains($l->id) ? 'selected':'' }}>
                        {{ $l->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Update</button>

    </form>

</div>
@endsection
