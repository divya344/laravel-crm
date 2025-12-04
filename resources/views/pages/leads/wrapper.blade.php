@extends('layouts.crm') {{-- ✅ This ensures sidebar + top navbar load --}}

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary mb-0">Leads</h4>
        <a href="{{ route('leads.create') }}" class="btn btn-success">
            <i class="mdi mdi-plus"></i> Add New Lead
        </a>
    </div>

    {{-- Kanban View --}}
    <div class="kanban-board row g-4">
        @foreach($boards as $board)
        <div class="col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-{{ $board['color'] }} text-white fw-bold">
                    {{ $board['name'] }}
                    <span class="badge bg-light text-dark float-end">
                        {{ count($board['leads']) }}
                    </span>
                </div>

                <div class="card-body p-2" style="min-height: 400px; background-color: #f9f9f9;">
                    @if(count($board['leads']) > 0)
                        @foreach($board['leads'] as $lead)
                            <div class="mb-2 p-3 bg-white border rounded shadow-sm">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="fw-bold text-primary mb-1">
                                        {{ $lead->lead_name ?? 'Untitled Lead' }}
                                    </h6>

                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('leads.edit', $lead->lead_id) }}">
                                                    <i class="mdi mdi-pencil-outline me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('leads.destroy', $lead->lead_id) }}" method="POST" onsubmit="return confirm('Delete this lead?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="mdi mdi-delete-outline me-2"></i>Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="small text-muted mt-2">
                                    <p class="mb-1"><strong>Email:</strong> {{ $lead->lead_email ?? '---' }}</p>
                                    <p class="mb-1"><strong>Phone:</strong> {{ $lead->lead_phone ?? '---' }}</p>
                                    <p class="mb-0"><small>
                                        Created on:
                                        {{ $lead->lead_created ? \Carbon\Carbon::parse($lead->lead_created)->format('d M Y') : '---' }}
                                    </small></p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="mdi mdi-inbox-outline fs-1"></i>
                            <p class="mt-2">No leads found in this stage</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
