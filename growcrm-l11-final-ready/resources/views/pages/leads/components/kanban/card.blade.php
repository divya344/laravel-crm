@foreach($board['leads'] as $lead)
<div class="kanban-card" id="card_lead_{{ $lead->lead_id }}">
    <div class="kanban-card-content p-3 rounded shadow-sm border bg-white">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-start mb-2">
            <h6 class="fw-bold mb-0 text-primary">
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
                        <form action="{{ route('leads.destroy', $lead->lead_id) }}" method="POST"
                            onsubmit="return confirm('Delete this lead?')">
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

        {{-- Body --}}
        <div class="small text-muted">
            <p class="mb-1"><strong>Email:</strong> {{ $lead->lead_email ?? '---' }}</p>
            <p class="mb-1"><strong>Phone:</strong> {{ $lead->lead_phone ?? '---' }}</p>
            <p class="mb-1"><strong>Status:</strong>
                <span class="badge 
                    @if($lead->lead_status == 'new') bg-info
                    @elseif($lead->lead_status == 'contacted') bg-primary
                    @elseif($lead->lead_status == 'qualified') bg-warning
                    @elseif($lead->lead_status == 'converted') bg-success
                    @elseif($lead->lead_status == 'closed') bg-danger
                    @else bg-secondary @endif">
                    {{ ucfirst($lead->lead_status ?? 'unknown') }}
                </span>
            </p>
            <p class="mb-0">
                <small>Created on:
                    {{ $lead->lead_created ? \Carbon\Carbon::parse($lead->lead_created)->format('d M Y') : '---' }}
                </small>
            </p>
        </div>
    </div>
</div>
@endforeach
