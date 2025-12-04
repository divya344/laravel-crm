@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2>Edit Ticket</h2>

    <form action="{{ route('tickets.update', $ticket->ticket_id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Subject --}}
        <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text" 
                   name="ticket_subject" 
                   class="form-control" 
                   value="{{ $ticket->ticket_subject }}" 
                   required>
        </div>

        {{-- Message --}}
        <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="ticket_message" 
                      class="form-control" 
                      rows="4">{{ $ticket->ticket_message }}</textarea>
        </div>

        {{-- Priority --}}
        <div class="mb-3">
            <label class="form-label">Priority</label>
            <select name="ticket_priority" class="form-control">
                <option value="low" {{ $ticket->ticket_priority == 'low' ? 'selected' : '' }}>Low</option>
                <option value="medium" {{ $ticket->ticket_priority == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="high" {{ $ticket->ticket_priority == 'high' ? 'selected' : '' }}>High</option>
            </select>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="ticket_status" class="form-control">
                <option value="open"        {{ $ticket->ticket_status == 'open' ? 'selected' : '' }}>Open</option>
                <option value="in_progress" {{ $ticket->ticket_status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="answered"    {{ $ticket->ticket_status == 'answered' ? 'selected' : '' }}>Answered</option>
                <option value="closed"      {{ $ticket->ticket_status == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        <button class="btn btn-primary">Update Ticket</button>
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Back</a>

    </form>

</div>
@endsection
