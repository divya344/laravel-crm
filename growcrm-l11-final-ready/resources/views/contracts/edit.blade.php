@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2>Edit Contract</h2>

    <div class="card shadow-sm mt-3">
        <div class="card-body">

            <form action="{{ route('contracts.update', $contract->doc_id) }}" method="POST">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Contract Title</label>
                    <input type="text" name="doc_title" value="{{ $contract->doc_title }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Client</label>
                    <select name="doc_clientid" class="form-control" required>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ $contract->doc_clientid == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Start Date</label>
                        <input type="date" name="doc_date_start" class="form-control"
                               value="{{ $contract->doc_date_start ? $contract->doc_date_start->format('Y-m-d') : '' }}">
                    </div>
                    <div class="col">
                        <label>End Date</label>
                        <input type="date" name="doc_date_end" class="form-control"
                               value="{{ $contract->doc_date_end ? $contract->doc_date_end->format('Y-m-d') : '' }}">
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <label>Contract Value (₹)</label>
                    <input type="number" name="doc_value" value="{{ $contract->doc_value }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="doc_status" class="form-control">
                        <option {{ $contract->doc_status==='draft' ? 'selected':'' }} value="draft">Draft</option>
                        <option {{ $contract->doc_status==='active' ? 'selected':'' }} value="active">Active</option>
                        <option {{ $contract->doc_status==='expired' ? 'selected':'' }} value="expired">Expired</option>
                        <option {{ $contract->doc_status==='cancelled' ? 'selected':'' }} value="cancelled">Cancelled</option>
                    </select>
                </div>

                <button class="btn btn-warning">Update Contract</button>
                <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Cancel</a>

            </form>

        </div>
    </div>

</div>
@endsection
