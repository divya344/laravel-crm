<h4>Comments</h4>

<form method="POST" action="{{ route('tasks.comments.store',$task->task_id) }}">
    @csrf
    <textarea name="comment" class="form-control" placeholder="Add comment"></textarea>
    <button class="btn btn-primary mt-2">Post</button>
</form>

@foreach($task->comments as $c)
    <div class="border p-2 mt-2">
        <strong>{{ $c->user->name }}</strong>
        <p>{{ $c->comment }}</p>
        <small>{{ $c->created_at }}</small>
    </div>
@endforeach
