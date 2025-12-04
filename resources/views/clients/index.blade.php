@extends('layouts.app')

@section('title','Clients')

@section('header-actions')
  <a href="{{ route('clients.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded">+ Add New</a>
@endsection

@section('content')
<div class="bg-white p-4 rounded shadow">
  <table class="w-full">
    <thead><tr class="text-left"><th>Name</th><th>Email</th><th>Company</th><th>Actions</th></tr></thead>
    <tbody>
      @foreach($clients as $c)
        <tr class="border-t">
          <td>{{ $c->name }}</td><td>{{ $c->email }}</td><td>{{ $c->company }}</td>
          <td>
            <a href="{{ route('clients.edit', $c) }}">Edit</a> |
            <form action="{{ route('clients.destroy', $c) }}" method="POST" style="display:inline">@csrf @method('DELETE')<button onclick="return confirm('Delete?')">Delete</button></form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <div class="mt-4">{{ $clients->links() }}</div>
</div>
@endsection
