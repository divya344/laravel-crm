@extends('layouts.app')
@section('content')
<h1>Users</h1>
<table class="table table-striped">
<thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Actions</th></tr></thead>
<tbody>
@foreach($users as $u)
<tr>
<td>{{ $u->name }}</td>
<td>{{ $u->email }}</td>
<td>{{ $u->role }}</td>
<td>
  <a href="{{ route('users.edit', $u) }}" class="btn btn-sm btn-secondary">Edit</a>
  <form action="{{ route('users.destroy', $u) }}" method="POST" style="display:inline">@csrf @method('DELETE')
    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete user?')">Delete</button>
  </form>
</td>
</tr>
@endforeach
</tbody>
</table>
<div>{{ $users->links() }}</div>
@endsection
