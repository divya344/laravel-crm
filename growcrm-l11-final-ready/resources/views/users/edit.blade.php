@extends('layouts.app')
@section('content')
<h1>Edit User</h1>
<form method="POST" action="{{ route('users.update', $user) }}">
@csrf @method('PUT')
<div class="form-group"><label>Name</label><input name="name" value="{{ old('name',$user->name) }}" class="form-control" required></div>
<div class="form-group"><label>Email</label><input name="email" value="{{ old('email',$user->email) }}" class="form-control" required></div>
<div class="form-group"><label>Role</label><select name="role" class="form-control">@foreach($roles as $r)<option value="{{ $r }}" {{ $user->role===$r?'selected':'' }}>{{ ucfirst($r) }}</option>@endforeach</select></div>
<button class="btn btn-primary">Save</button>
<a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
