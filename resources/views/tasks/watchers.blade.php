<h4>Watchers</h4>

<form method="POST" action="{{ route('tasks.watch',$task->task_id) }}">
    @csrf
    <button class="btn btn-secondary">Watch</button>
</form>

<form method="POST" action="{{ route('tasks.unwatch',$task->task_id) }}" class="mt-2">
    @csrf @method('DELETE')
    <button class="btn btn-warning">Unwatch</button>
</form>

<ul class="list-group mt-2">
    @foreach($task->watchers as $w)
        <li class="list-group-item">{{ $w->name }}</li>
    @endforeach
</ul>
