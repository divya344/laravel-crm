@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Tickets</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">Create Ticket</a>

    <div class="card">
        <div class="card-body">

            @if ($tickets->isEmpty())
                <p>No tickets found.</p>
            @else
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->ticket_id }}</td>

                                <td>{{ $ticket->ticket_subject }}</td>

                                <td>
                                    <span class="badge 
                                        @if($ticket->ticket_status == 'open') bg-success
                                        @elseif($ticket->ticket_status == 'in_progress') bg-warning
                                        @elseif($ticket->ticket_status == 'answered') bg-info
                                        @else bg-secondary
                                        @endif
                                    ">
                                        {{ ucfirst($ticket->ticket_status) }}
                                    </span>
                                </td>

                                {{-- Correct timestamp column --}}
                                <td>{{ $ticket->ticket_created ? $ticket->ticket_created->format('Y-m-d H:i') : '-' }}</td>

                                <td>
                                    <a href="{{ route('tickets.show', $ticket->ticket_id) }}" class="btn btn-sm btn-info">View</a>

                                    <a href="{{ route('tickets.edit', $ticket->ticket_id) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('tickets.destroy', $ticket->ticket_id) }}" 
                                          method="POST" 
                                          style="display:inline-block;">
                                        @csrf 
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Delete this ticket?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            @endif

        </div>
    </div>
</div>
@endsection
