@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Create Ticket</h2>

    <form action="{{ route('tickets.store') }}" method="POST">
        @csrf

        {{-- Subject --}}
        <div class="mb-3">
            <label class="form-label">Subject</label>
            <input type="text" name="ticket_subject" class="form-control" required>
        </div>

        {{-- Message --}}
        <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="ticket_message" class="form-control" rows="4"></textarea>
        </div>

        {{-- Select Client --}}
        <div class="mb-3">
            <label class="form-label">Select Client</label>
            <select name="ticket_clientid" class="form-control">
                <option value="">-- None --</option>
                @foreach($clients as $client)
                    <option value="{{ $client->client_id }}">
                        {{ $client->client_company_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Select Project --}}
        <div class="mb-3">
            <label class="form-label">Select Project</label>
            <select name="ticket_projectid" class="form-control">
                <option value="">-- None --</option>
                @foreach($projects as $project)
                    <option value="{{ $project->project_id }}">
                        {{ $project->project_title }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Submit --}}
        <button class="btn btn-success">Create Ticket</button>
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Back</a>

    </form>

</div>
@endsection
