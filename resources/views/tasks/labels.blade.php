<h4>Labels</h4>

<form method="POST" action="{{ route('tasks.labels.attach',$task->task_id) }}">
    @csrf
    <select name="labels[]" multiple class="form-select mb-2">
        @foreach(\App\Models\Label::all() as $l)
            <option value="{{ $l->id }}">{{ $l->name }}</option>
        @endforeach
    </select>
    <button class="btn btn-primary">Add Labels</button>
</form>

<div class="mt-2">
@foreach($task->labels as $l)
    <span class="badge p-2" style="background: {{ $l->color }}">
        {{ $l->name }}
    </span>
@endforeach
</div>
