@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2>Contract Details</h2>

    <div class="card shadow-sm mt-3">
        <div class="card-body">

            <h4>{{ $contract->doc_title }}</h4>
            <p><strong>Contract ID:</strong> {{ $contract->formatted_id }}</p>

            <p><strong>Client:</strong> {{ $contract->client->name ?? '—' }}</p>
            <p><strong>Status:</strong> <span class="badge bg-success">{{ ucfirst($contract->doc_status) }}</span></p>
            <p><strong>Value:</strong> ₹{{ number_format($contract->doc_value ?? 0,2) }}</p>

            <p><strong>Start Date:</strong> {{ $contract->formatted_doc_date_start ?? '—' }}</p>
            <p><strong>End Date:</strong> {{ $contract->formatted_doc_date_end ?? '—' }}</p>

            <hr>

            <a href="{{ route('contracts.edit', $contract->doc_id) }}" class="btn btn-warning">Edit</a>

            <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Back</a>

        </div>
    </div>

</div>
@endsection
