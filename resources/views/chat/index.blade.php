@extends('layouts.app')

@section('content')
<meta name="user-id" content="{{ $user->id }}">
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header">
                    <strong>Users</strong>
                </div>
                <div class="list-group list-group-flush" style="max-height: 70vh; overflow-y:auto;">
                    @foreach($users as $u)
                        <a href="{{ route('chat.index', ['user_id' => $u->id]) }}"
                           class="list-group-item list-group-item-action {{ $activeUserId == $u->id ? 'active' : '' }}">
                            {{ $u->name }}
                            <small class="d-block text-muted">{{ $u->email }}</small>
                        </a>
                    @endforeach
                </div>
                <div class="card-footer">
                    <form method="GET" action="{{ route('chat.index') }}">
                        <div class="input-group input-group-sm">
                            <input type="text" name="channel" class="form-control" placeholder="Group name..."
                                   value="{{ $activeChannel }}">
                            <button class="btn btn-outline-secondary" type="submit">Join</button>
                        </div>
                        <small class="text-muted d-block mt-1">Use any name for group chat (e.g. <code>project-1</code>).</small>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <strong>Chat</strong>
                        @if($activeUserId)
                            @php $activeUser = $users->firstWhere('id', $activeUserId); @endphp
                            @if($activeUser)
                                <span class="text-muted">with {{ $activeUser->name }}</span>
                            @endif
                        @elseif($activeChannel)
                            <span class="text-muted">Channel: #{{ $activeChannel }}</span>
                        @else
                            <span class="text-muted">Recent conversations</span>
                        @endif
                    </div>
                    <small>Logged in as: {{ $user->name }}</small>
                </div>
                <div class="card-body" id="chat-messages" style="height:60vh; overflow-y:auto;">
                    @foreach($messages as $m)
                        <div class="mb-3 {{ $m->sender_id === $user->id ? 'text-end' : 'text-start' }}">
                            <div class="d-inline-block p-2 rounded {{ $m->sender_id === $user->id ? 'bg-primary text-white' : 'bg-light' }}">
                                <div class="small fw-bold">
                                    {{ $m->sender ? $m->sender->name : 'System' }}
                                    <span class="text-muted fw-normal">· {{ $m->created_at->format('d M Y H:i') }}</span>
                                </div>
                                @if($m->body)
                                    <div>{!! nl2br(e($m->body)) !!}</div>
                                @endif
                                @if($m->attachment_path)
                                    <div class="mt-1">
                                        <a href="{{ Storage::url($m->attachment_path) }}" target="_blank" class="text-decoration-underline">
                                            Download attachment
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('chat.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $activeUserId }}">
                        <input type="hidden" name="channel" value="{{ $activeChannel }}">
                        <div class="mb-2">
                            <textarea name="body" class="form-control" rows="2" placeholder="Type your message..."></textarea>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-2">
                                <input type="file" name="attachment" class="form-control form-control-sm">
                                <small class="text-muted">Optional file (max 10MB)</small>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">Send</button>
                                <a href="{{ route('chat.index') }}" class="btn btn-light">Clear</a>
                            </div>
                        </div>
                        @if($errors->any())
                            <div class="alert alert-danger mt-2">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success mt-2">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger mt-2">
                                {{ session('error') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
