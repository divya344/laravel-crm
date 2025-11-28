@extends('layouts.app')

@section('title', 'Estimates')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Estimates</h2>
        <a href="{{ route('estimates.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> New Estimate
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($estimates->count())
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Estimate Number</th>
                            <th>Client</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date Created</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($estimates as $estimate)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $estimate->estimate_number }}</td>
                            <td>{{ $estimate->client_name }}</td>
                            <td>${{ number_format($estimate->amount, 2) }}</td>
                            <td>
                                <span class="badge 
                                    @if($estimate->status == 'approved') bg-success 
                                    @elseif($estimate->status == 'rejected') bg-danger 
                                    @elseif($estimate->status == 'sent') bg-info 
                                    @else bg-secondary @endif">
                                    {{ ucfirst($estimate->status) }}
                                </span>
                            </td>

                            {{-- ✅ Safely show bill_created or fallback --}}
                            <td>
                                @if(!empty($estimate->bill_created))
                                    {{ \Carbon\Carbon::parse($estimate->bill_created)->format('d M, Y') }}
                                @elseif(!empty($estimate->created_at))
                                    {{ $estimate->created_at->format('d M, Y') }}
                                @else
                                    —
                                @endif
                            </td>

                            <td class="text-end">
                                <a href="{{ route('estimates.show', $estimate) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('estimates.edit', $estimate) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('estimates.destroy', $estimate) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure you want to delete this estimate?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white border-0">
                {{ $estimates->links() }}
            </div>
        </div>
    @else
        <div class="text-center text-muted mt-5">
            <h5>No estimates found.</h5>
            <p class="small">Click the “New Estimate” button to create one.</p>
        </div>
    @endif
</div>
@endsection
