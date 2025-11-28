@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Task Title & Description --}}
    <h3>{{ $task->task_title }}</h3>
    <p class="text-muted">{{ $task->task_description }}</p>

    <hr>

    {{-- Partial Modules --}}
    @includeIf('tasks.partials.subtasks')
    @includeIf('tasks.partials.comments')
    @includeIf('tasks.partials.files')
    @includeIf('tasks.partials.labels')
    @includeIf('tasks.partials.watchers')

    {{-- Activity Log --}}
    <h4 class="mt-4">Activity Log</h4>
    <ul class="list-group">
        @forelse($task->activity as $a)
            <li class="list-group-item">
                <strong>{{ $a->user->name ?? 'System' }}</strong> – {{ $a->message }}
                <br>
                <small class="text-muted">{{ $a->created_at }}</small>
            </li>
        @empty
            <li class="list-group-item text-muted">No activity logged yet.</li>
        @endforelse
    </ul>

</div>
@endsection
