@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2>Create Contract</h2>
    
    <div class="card shadow-sm mt-3">
        <div class="card-body">

            <form action="{{ route('contracts.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Contract Title</label>
                    <input type="text" name="doc_title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Client</label>
                    <select name="doc_clientid" class="form-control" required>
                        <option value="">-- Select Client --</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Start Date</label>
                        <input type="date" name="doc_date_start" class="form-control">
                    </div>
                    <div class="col">
                        <label>End Date</label>
                        <input type="date" name="doc_date_end" class="form-control">
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <label>Contract Value (₹)</label>
                    <input type="number" name="doc_value" class="form-control" step="0.01">
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="doc_status" class="form-control">
                        <option value="draft">Draft</option>
                        <option value="active">Active</option>
                        <option value="expired">Expired</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <button class="btn btn-primary">Create Contract</button>
                <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Cancel</a>

            </form>

        </div>
    </div>

</div>
@endsection
