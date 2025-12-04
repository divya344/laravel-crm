@extends('layouts.crm')

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary mb-0">
            <i class="mdi mdi-cash-multiple"></i> Payments
        </h4>
        <a href="{{ route('payments.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> New Payment
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Payments Table --}}
    @if($payments->count())
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Reference</th>
                            <th>Client</th>
                            <th>Method</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration + ($payments->currentPage() - 1) * $payments->perPage() }}</td>

                            {{-- Reference --}}
                            <td>{{ $payment->payment_reference ?? '—' }}</td>

                            {{-- Client --}}
                            <td>
                                {{ $payment->client->name ?? $payment->client->client_name ?? '—' }}
                            </td>

                            {{-- Method --}}
                            <td>{{ $payment->payment_method ?? '—' }}</td>

                            {{-- Amount --}}
                            <td><strong>{{ $payment->formatted_amount }}</strong></td>

                            {{-- Status --}}
                            <td>
                                <span class="badge 
                                    @if($payment->payment_status === 'completed') bg-success 
                                    @elseif($payment->payment_status === 'pending') bg-warning 
                                    @else bg-danger @endif">
                                    {{ ucfirst($payment->payment_status) }}
                                </span>
                            </td>

                            {{-- Payment Date --}}
                            <td>
                                {{ $payment->payment_date 
                                    ? $payment->payment_date->format('d M Y') 
                                    : '—' }}
                            </td>

                            {{-- Actions --}}
                            <td class="text-end">
                                {{-- View --}}
                                <a href="{{ route('payments.show', $payment) }}" 
                                   class="btn btn-sm btn-outline-info" 
                                   title="View">
                                    View
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('payments.edit', $payment) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="Edit">Edit
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('payments.destroy', $payment) }}" 
                                      method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete this payment?')"
                                            title="Delete">Delete
                                        
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="card-footer bg-white border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="mb-0 text-muted small">
                        Showing {{ $payments->firstItem() }}–{{ $payments->lastItem() }} of {{ $payments->total() }} records
                    </p>
                    {{ $payments->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    @else
        <div class="text-center text-muted mt-5">
            <h5>No payments found.</h5>
            <p class="small">Click the “New Payment” button to create one.</p>
        </div>
    @endif
</div>
@endsection
