<h4 class="mt-4">Subtasks</h4>

<!-- Add New Subtask -->
<form method="POST" action="{{ route('tasks.subtasks.store', $task->task_id) }}" class="mb-3 d-flex gap-2">
    @csrf
    <input type="text" name="title" placeholder="New subtask" class="form-control" required>
    <button type="submit" class="btn btn-primary">Add</button>
</form>

<!-- Subtask List -->
<ul class="list-group">
@foreach($task->subtasks as $s)
    <li class="list-group-item d-flex align-items-center justify-content-between">

        <div>
            <form action="{{ route('subtasks.toggle', $s->id) }}" method="POST" class="d-inline">
                @csrf
                <input type="checkbox" onchange="this.form.submit()" {{ $s->completed ? 'checked' : '' }}>
            </form>

            <span class="{{ $s->completed ? 'text-decoration-line-through text-muted' : '' }}">
                {{ $s->title }}
            </span>
        </div>

    </li>
@endforeach
</ul>
