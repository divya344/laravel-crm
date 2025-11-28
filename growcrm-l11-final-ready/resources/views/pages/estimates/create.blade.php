@extends('layouts.crm')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary mb-0"><i class="mdi mdi-file-plus"></i> New Estimate</h4>
        <a href="{{ route('estimates.index') }}" class="btn btn-secondary"><i class="mdi mdi-arrow-left"></i> Back</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('estimates.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Estimate Number</label>
                        <input type="text" name="estimate_number" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Client Name</label>
                        <input type="text" name="client_name" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Amount</label>
                        <input type="number" step="0.01" name="bill_amount" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="bill_status" class="form-select" required>
                            <option value="draft">Draft</option>
                            <option value="sent">Sent</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Date</label>
                        <input type="date" name="bill_date" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Expiry Date</label>
                        <input type="date" name="bill_expiry_date" class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Notes</label>
                        <textarea name="bill_notes" rows="3" class="form-control"></textarea>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary px-4"><i class="mdi mdi-content-save-outline"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
