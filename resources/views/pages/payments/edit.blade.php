@extends('layouts.crm')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary mb-0">
            <i class="mdi mdi-pencil"></i> Edit Payment
        </h4>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">
            <i class="mdi mdi-arrow-left"></i> Back
        </a>
    </div>

    {{-- Form --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('payments.update', $payment) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Reference Number</label>
                        <input type="text" name="reference_number" value="{{ old('reference_number', $payment->reference_number) }}"
                            class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Method</label>
                        <input type="text" name="method" value="{{ old('method', $payment->method) }}"
                            class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Amount</label>
                        <input type="number" step="0.01" name="amount"
                            value="{{ old('amount', $payment->amount) }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $payment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Payment Date</label>
                        <input type="date" name="payment_date" value="{{ old('payment_date', $payment->payment_date) }}"
                            class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Notes</label>
                        <textarea name="notes" rows="3" class="form-control">{{ old('notes', $payment->notes) }}</textarea>
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="mdi mdi-content-save"></i> Update Payment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
