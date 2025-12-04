@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <strong>Upload New File</strong>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('files.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Choose file</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                            <small class="text-muted">Max size: 20MB</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>

                        @if($errors->any())
                            <div class="alert alert-danger mt-2">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success mt-2">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger mt-2">
                                {{ session('error') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <strong>My Files</strong>
                    <small>{{ $files->total() }} files</small>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                @if($user->isAdmin() || $user->isManager())
                                    <th>Owner</th>
                                @endif
                                <th>Size</th>
                                <th>Uploaded</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($files as $file)
                            <tr>
                                <td>{{ $file->original_name }}</td>
                                @if($user->isAdmin() || $user->isManager())
                                    <td>{{ optional($file->user)->name ?? 'Unknown' }}</td>
                                @endif
                                <td>
                                    @php
                                        $size = $file->size ?? 0;
                                        if ($size > 1024*1024) {
                                            $sizeText = round($size / (1024*1024), 2) . ' MB';
                                        } elseif ($size > 1024) {
                                            $sizeText = round($size / 1024, 2) . ' KB';
                                        } else {
                                            $sizeText = $size . ' B';
                                        }
                                    @endphp
                                    {{ $sizeText }}
                                </td>
                                <td>{{ $file->created_at->format('d M Y H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('files.download', $file) }}" class="btn btn-sm btn-outline-primary">
                                        Download
                                    </a>
                                    <form action="{{ route('files.destroy', $file) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this file?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    No files uploaded yet.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if($files->hasPages())
                    <div class="card-footer">
                        {{ $files->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
