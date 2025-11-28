@extends('layouts.app')

@section('title','Add Invoice')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-2xl">
  <form action="{{ route('invoices.store') }}" method="POST">
    @csrf
    <div class="mb-4"><label class="block text-sm">Invoice Number</label><input type="text" name="number" class="w-full border p-2 rounded" required></div>
    <div class="mb-4"><label class="block text-sm">Project</label><select name="project_id" class="w-full border p-2 rounded"><option value="">—</option>@foreach($projects as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select></div>
    <div class="mb-4"><label class="block text-sm">Amount</label><input type="number" step="0.01" name="amount" class="w-full border p-2 rounded" required></div>
    <div><button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button></div>
  </form>
</div>
@endsection
