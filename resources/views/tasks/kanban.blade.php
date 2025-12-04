@extends('layouts.app')

@section('content')
<div class="container">

    <h3>Kanban Board</h3>

    <div class="row">

        @php
            $columns = [
                'pending'      => 'Pending',
                'in_progress'  => 'In Progress',
                'completed'    => 'Completed'
            ];
        @endphp

        @foreach($columns as $key => $column)
        <div class="col-md-4">
            <h5 class="text-center">{{ $column }}</h5>

            <div class="kanban-column p-2 border rounded bg-light min-vh-50"
                 data-status="{{ $key }}">

                @foreach($grouped[$key] as $task)
                    <div class="kanban-task card mb-2 p-2 shadow-sm"
                         draggable="true"
                         data-id="{{ $task->task_id }}">
                        <strong>{{ $task->task_title }}</strong>
                    </div>
                @endforeach

            </div>
        </div>
        @endforeach

    </div>

</div>

{{-- JS --}}
<script>
    // --------------- DRAG START -----------------
    document.querySelectorAll('.kanban-task').forEach(task => {
        task.addEventListener('dragstart', e => {
            e.dataTransfer.setData('task_id', task.dataset.id);
            task.classList.add('opacity-50');
        });

        task.addEventListener('dragend', e => {
            task.classList.remove('opacity-50');
        });
    });

    // --------------- DRAG OVER / DROP -----------------
    document.querySelectorAll('.kanban-column').forEach(col => {

        col.addEventListener('dragover', e => {
            e.preventDefault();
        });

        col.addEventListener('drop', e => {
            e.preventDefault();

            let task_id = e.dataTransfer.getData('task_id');
            let status = col.dataset.status;

            // UI: Move card instantly without reloading
            let card = document.querySelector(`[data-id='${task_id}']`);
            col.appendChild(card);

            // Send update
            fetch("{{ route('tasks.kanban.update') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ task_id, status })
            });
        });
    });
</script>

@endsection
