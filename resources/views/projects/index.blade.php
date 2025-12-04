@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h3>Projects</h3>
        <a href="{{ route('projects.create') }}" class="btn btn-primary">+ Create Project</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Client</th>
                        <th>Status</th>
                        <th width="180">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($projects as $p)
                        <tr>
                            <td>{{ $p->project_title }}</td>
                            <td>{{ $p->client->client_name ?? '—' }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ ucfirst($p->project_status) }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('projects.show', $p->project_id) }}" class="btn btn-sm btn-secondary">View</a>
                                <a href="{{ route('projects.edit', $p->project_id) }}" class="btn btn-sm btn-primary">Edit</a>

                                <form action="{{ route('projects.destroy', $p->project_id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this project?')"
                                            class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                No projects found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>
</div>
@endsection
