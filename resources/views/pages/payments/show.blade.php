@extends('layouts.crm')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary mb-0">
            <i class="mdi mdi-cash-check"></i> Payment Details
        </h4>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">
            <i class="mdi mdi-arrow-left"></i> Back
        </a>
    </div>

    {{-- Details --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Reference Number:</strong> {{ $payment->reference_number }}</p>
                    <p><strong>Method:</strong> {{ $payment->method }}</p>
                    <p><strong>Amount:</strong> ${{ number_format($payment->amount, 2) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status:</strong>
                        <span class="badge 
                            @if($payment->status == 'completed') bg-success
                            @elseif($payment->status == 'pending') bg-warning
                            @else bg-danger @endif">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </p>
                    <p><strong>Date:</strong> 
                        {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M, Y') : '—' }}
                    </p>
                </div>
            </div>

            <div>
                <strong>Notes:</strong>
                <p class="mt-2">{{ $payment->notes ?: 'No notes provided.' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
