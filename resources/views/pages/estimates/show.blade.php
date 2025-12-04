@extends('layouts.crm')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary mb-0"><i class="mdi mdi-file-eye"></i> Estimate Details</h4>
        <a href="{{ route('estimates.index') }}" class="btn btn-secondary"><i class="mdi mdi-arrow-left"></i> Back</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <h6 class="fw-bold">Estimate Number:</h6>
                    <p>{{ $estimate->estimate_number }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Client:</h6>
                    <p>{{ $estimate->client_name ?? '—' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Amount:</h6>
                    <p>${{ number_format($estimate->bill_amount, 2) }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Status:</h6>
                    <span class="badge {{ $estimate->status_badge_class }}">{{ ucfirst($estimate->bill_status) }}</span>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Date:</h6>
                    <p>{{ $estimate->bill_date ?? '—' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Expiry Date:</h6>
                    <p>{{ $estimate->bill_expiry_date ?? '—' }}</p>
                </div>
                <div class="col-12">
                    <h6 class="fw-bold">Notes:</h6>
                    <p>{{ $estimate->bill_notes ?? 'No notes provided.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
