@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-3">Ticket Details</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-3">Ticket #{{ $ticket->ticket_id }}</h4>

            <p><strong>Subject:</strong> {{ $ticket->ticket_subject }}</p>

            <p><strong>Message:</strong><br>
                {!! nl2br(e($ticket->ticket_message ?? 'No message provided')) !!}
            </p>

            <p><strong>Status:</strong> 
                <span class="badge 
                    @if($ticket->ticket_status == 'open') bg-success
                    @elseif($ticket->ticket_status == 'in_progress') bg-warning
                    @elseif($ticket->ticket_status == 'answered') bg-info
                    @else bg-secondary
                    @endif
                ">
                    {{ ucfirst($ticket->ticket_status) }}
                </span>
            </p>

            @if($ticket->ticket_priority)
                <p><strong>Priority:</strong> {{ ucfirst($ticket->ticket_priority) }}</p>
            @endif

            <p><strong>Created At:</strong> 
                {{ $ticket->ticket_created ? $ticket->ticket_created->format('d M Y, h:i A') : '-' }}
            </p>

            <p><strong>Last Updated:</strong> 
                {{ $ticket->ticket_updated ? $ticket->ticket_updated->format('d M Y, h:i A') : '-' }}
            </p>

            <a href="{{ route('tickets.index') }}" class="btn btn-secondary mt-3">Back</a>
        </div>
    </div>

</div>
@endsection
