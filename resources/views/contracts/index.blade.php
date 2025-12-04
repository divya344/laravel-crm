@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Contracts</h2>
        <a href="{{ route('contracts.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Contract
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Client</th>
                        <th>Status</th>
                        <th>Value</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($contracts as $contract)
                        <tr>
                            <td>{{ $contract->formatted_id }}</td>
                            <td>{{ $contract->doc_title }}</td>
                            <td>{{ $contract->client->name ?? '—' }}</td>
                            <td><span class="badge bg-info">{{ ucfirst($contract->doc_status) }}</span></td>
                            <td>₹{{ number_format($contract->doc_value ?? 0,2) }}</td>
                            <td>{{ $contract->formatted_doc_created }}</td>
                            <td>
                                <a href="{{ route('contracts.show', $contract->doc_id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('contracts.edit', $contract->doc_id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('contracts.destroy', $contract->doc_id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Delete contract?')" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-3">No contracts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $contracts->links() }}
    </div>

</div>
@endsection
