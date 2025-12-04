@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Create New Task</h3>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <div class="row">

            {{-- Left Column --}}
            <div class="col-md-6">

                {{-- Title --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Title</label>
                    <input 
                        type="text" 
                        name="task_title" 
                        class="form-control @error('task_title') is-invalid @enderror"
                        value="{{ old('task_title') }}"
                        required
                    >
                    @error('task_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea 
                        name="task_description" 
                        class="form-control"
                        rows="4"
                    >{{ old('task_description') }}</textarea>
                </div>

                {{-- Project --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Project</label>
                    <select 
                        name="task_projectid" 
                        class="form-control @error('task_projectid') is-invalid @enderror"
                        required
                    >
                        <option value="">-- Select Project --</option>
                        @foreach($projects as $p)
                            <option 
                                value="{{ $p->project_id }}"
                                {{ old('task_projectid') == $p->project_id ? 'selected' : '' }}
                            >
                                {{ $p->project_title }}
                            </option>
                        @endforeach
                    </select>
                    @error('task_projectid')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            {{-- Right Column --}}
            <div class="col-md-6">

                {{-- Due Date --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Due Date</label>
                    <input 
                        type="date" 
                        name="task_due_date" 
                        class="form-control"
                        value="{{ old('task_due_date') }}"
                    >
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select 
                        name="task_status" 
                        class="form-control"
                    >
                        <option value="pending"     {{ old('task_status')=='pending'?'selected':'' }}>Pending</option>
                        <option value="in_progress" {{ old('task_status')=='in_progress'?'selected':'' }}>In Progress</option>
                        <option value="completed"   {{ old('task_status')=='completed'?'selected':'' }}>Completed</option>
                        <option value="cancelled"   {{ old('task_status')=='cancelled'?'selected':'' }}>Cancelled</option>
                    </select>
                </div>

                {{-- Priority --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Priority</label>
                    <select name="task_priority" class="form-control">
                        <option value="low"    {{ old('task_priority')=='low'?'selected':'' }}>Low</option>
                        <option value="medium" {{ old('task_priority','medium')=='medium'?'selected':'' }}>Medium</option>
                        <option value="high"   {{ old('task_priority')=='high'?'selected':'' }}>High</option>
                    </select>
                </div>

                {{-- Assign Users --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Assign Users</label>
                    <select name="assigned_users[]" class="form-control" multiple size="4">
                        @foreach($users as $u)
                            <option 
                                value="{{ $u->id }}"
                                {{ collect(old('assigned_users'))->contains($u->id) ? 'selected' : '' }}
                            >
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Hold CTRL to select multiple users</small>
                </div>

                {{-- Labels --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Labels</label>
                    <select name="labels[]" class="form-control" multiple size="4">
                        @foreach($labels as $l)
                            <option 
                                value="{{ $l->id }}"
                                {{ collect(old('labels'))->contains($l->id) ? 'selected' : '' }}
                            >
                                {{ $l->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Select one or more labels</small>
                </div>

            </div>

        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary px-4">Save Task</button>
        </div>

    </form>

</div>
@endsection
