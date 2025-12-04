@extends('layouts.app')
@section('content')
<h1>Create User</h1>
<form method="POST" action="{{ route('users.store') }}">@csrf
<div class="form-group"><label>Name</label><input name="name" class="form-control" required></div>
<div class="form-group"><label>Email</label><input name="email" type="email" class="form-control" required></div>
<div class="form-group"><label>Password</label><input name="password" type="password" class="form-control" required></div>
<div class="form-group"><label>Confirm Password</label><input name="password_confirmation" type="password" class="form-control" required></div>
<div class="form-group"><label>Role</label><select name="role" class="form-control">@foreach($roles as $r)<option value="{{ $r }}">{{ ucfirst($r) }}</option>@endforeach</select></div>
<button class="btn btn-primary">Create</button>
<a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
