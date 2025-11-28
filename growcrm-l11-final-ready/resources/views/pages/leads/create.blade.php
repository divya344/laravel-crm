@extends('layouts.crm') {{-- ✅ This ensures sidebar + top navbar appear --}}

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary mb-0">
            <i class="mdi mdi-account-plus-outline"></i> Add New Lead
        </h4>
        <a href="{{ route('leads.index') }}" class="btn btn-secondary">
            <i class="mdi mdi-arrow-left"></i> Back to Leads
        </a>
    </div>

    {{-- Lead Form --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('leads.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    {{-- Lead Name --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Lead Name <span class="text-danger">*</span></label>
                        <input type="text" name="lead_name" value="{{ old('lead_name') }}"
                               class="form-control @error('lead_name') is-invalid @enderror"
                               placeholder="Enter full name" required>
                        @error('lead_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="lead_email" value="{{ old('lead_email') }}"
                               class="form-control @error('lead_email') is-invalid @enderror"
                               placeholder="Enter email address" required>
                        @error('lead_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" name="lead_phone" value="{{ old('lead_phone') }}"
                               class="form-control @error('lead_phone') is-invalid @enderror"
                               placeholder="Enter phone number">
                        @error('lead_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Lead Status --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="lead_status" class="form-select @error('lead_status') is-invalid @enderror" required>
                            <option value="">Select Status</option>
                            <option value="new" {{ old('lead_status') == 'new' ? 'selected' : '' }}>New</option>
                            <option value="contacted" {{ old('lead_status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="qualified" {{ old('lead_status') == 'qualified' ? 'selected' : '' }}>Qualified</option>
                            <option value="converted" {{ old('lead_status') == 'converted' ? 'selected' : '' }}>Converted</option>
                            <option value="closed" {{ old('lead_status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        @error('lead_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="mdi mdi-content-save-outline"></i> Save Lead
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
