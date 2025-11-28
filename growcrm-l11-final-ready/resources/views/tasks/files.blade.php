<h4 class="mt-4">Files</h4>

{{-- Upload Form --}}
<form method="POST" enctype="multipart/form-data"
      action="{{ route('tasks.files.store', $task->task_id) }}">
    @csrf

    <div class="input-group mb-3">
        <input type="file" name="file"
               class="form-control @error('file') is-invalid @enderror" required>
        <button class="btn btn-primary">Upload</button>

        @error('file')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</form>

{{-- File List --}}
<ul class="list-group mt-3">
    @forelse($task->files as $file)
        <li class="list-group-item d-flex justify-content-between align-items-center">

            {{-- File Download --}}
            <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank">
                {{ $file->file_name }}
            </a>

            {{-- Delete Button --}}
            <form method="POST" action="{{ route('tasks.files.delete', $file->file_id) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Delete</button>
            </form>

        </li>
    @empty
        <li class="list-group-item text-muted">No files uploaded.</li>
    @endforelse
</ul>
