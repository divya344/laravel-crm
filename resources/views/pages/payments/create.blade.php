@extends('layouts.crm')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary mb-0">
            <i class="mdi mdi-cash-plus"></i> New Payment
        </h4>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">
            <i class="mdi mdi-arrow-left"></i> Back to Payments
        </a>
    </div>

    {{-- Form Card --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('payments.store') }}" method="POST">
                @csrf
                <div class="row g-3">

                    {{-- Payment Reference (auto-generated) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Payment Reference</label>
                        <input type="text"
                               class="form-control"
                               value="Auto-generated after saving"
                               disabled>
                    </div>

                    {{-- Client --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Client</label>
                        <select name="payment_clientid"
                                class="form-select @error('payment_clientid') is-invalid @enderror">
                            <option value="">Select Client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->client_id }}"
                                    {{ old('payment_clientid') == $client->client_id ? 'selected' : '' }}>
                                    {{ $client->client_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('payment_clientid')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Payment Method --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Payment Method <span class="text-danger">*</span></label>
                        <input type="text"
                               name="payment_method"
                               value="{{ old('payment_method') }}"
                               class="form-control @error('payment_method') is-invalid @enderror"
                               placeholder="e.g., Credit Card, Bank Transfer"
                               required>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Amount --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Amount <span class="text-danger">*</span></label>
                        <input type="number"
                               name="payment_amount"
                               step="0.01"
                               value="{{ old('payment_amount') }}"
                               class="form-control @error('payment_amount') is-invalid @enderror"
                               placeholder="Enter payment amount"
                               required>
                        @error('payment_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="payment_status"
                                class="form-select @error('payment_status') is-invalid @enderror"
                                required>
                            <option value="">Select Status</option>
                            <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ old('payment_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ old('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                        @error('payment_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Payment Date --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Payment Date</label>
                        <input type="date"
                               name="payment_date"
                               value="{{ old('payment_date') }}"
                               class="form-control @error('payment_date') is-invalid @enderror">
                        @error('payment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Notes --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">Notes</label>
                        <textarea name="payment_notes"
                                  rows="3"
                                  class="form-control @error('payment_notes') is-invalid @enderror"
                                  placeholder="Additional notes...">{{ old('payment_notes') }}</textarea>
                        @error('payment_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="mdi mdi-content-save-outline"></i> Save Payment
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
