@extends('layouts.app')

@section('title','Add Project')

@section('content')
<div class="container mt-4">
    <div class="bg-white p-4 rounded shadow">

        <h3 class="mb-3">Create New Project</h3>

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf

            {{-- PROJECT TITLE --}}
            <div class="mb-3">
                <label class="form-label">Project Title</label>
                <input type="text" name="project_title" value="{{ old('project_title') }}"
                       class="form-control" required>
            </div>

            {{-- CLIENT --}}
            <div class="mb-3">
                <label class="form-label">Client</label>
                <select name="project_clientid" class="form-control">
                    <option value="">— Select Client —</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->client_id }}"
                                {{ old('project_clientid') == $client->client_id ? 'selected' : '' }}>
                            {{ $client->client_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- DESCRIPTION --}}
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="project_description" class="form-control" rows="4">
                    {{ old('project_description') }}
                </textarea>
            </div>

            {{-- START DATE --}}
            <div class="mb-3">
                <label class="form-label">Start Date</label>
                <input type="date" name="project_start_date" value="{{ old('project_start_date') }}"
                       class="form-control">
            </div>

            {{-- END DATE --}}
            <div class="mb-3">
                <label class="form-label">End Date</label>
                <input type="date" name="project_end_date" value="{{ old('project_end_date') }}"
                       class="form-control">
            </div>

            {{-- STATUS --}}
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="project_status" class="form-control">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                    <option value="on_hold">On Hold</option>
                </select>
            </div>

            {{-- BUTTONS --}}
            <div class="d-flex gap-2">
                <button class="btn btn-primary px-4">Save</button>
                <a href="{{ route('projects.index') }}" class="btn btn-light border px-4">Cancel</a>
            </div>
        </form>

    </div>
</div>
@endsection
