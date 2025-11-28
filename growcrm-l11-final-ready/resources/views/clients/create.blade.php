@extends('layouts.app')

@section('title','Add Client')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-2xl">
  <form action="{{ route('clients.store') }}" method="POST">
    @csrf
    <div class="mb-4"><label class="block text-sm">Name</label><input type="text" name="name" class="w-full border p-2 rounded" required></div>
    <div class="mb-4"><label class="block text-sm">Email</label><input type="email" name="email" class="w-full border p-2 rounded" required></div>
    <div class="mb-4"><label class="block text-sm">Company</label><input type="text" name="company" class="w-full border p-2 rounded"></div>
    <div class="mb-4"><label class="block text-sm">Address</label><textarea name="address" class="w-full border p-2 rounded"></textarea></div>
    <div><button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button></div>
  </form>
</div>
@endsection
