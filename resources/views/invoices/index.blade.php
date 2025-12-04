@extends('layouts.app')

@section('title','Invoices')

@section('header-actions')
  <a href="{{ route('invoices.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded">+ Add Invoice</a>
@endsection

@section('content')
<div class="bg-white p-4 rounded shadow">
  <table class="w-full">
    <thead><tr class="text-left"><th>Number</th><th>Project</th><th>Amount</th><th>Status</th></tr></thead>
    <tbody>
      @foreach($invoices as $inv)
        <tr class="border-t">
          <td>{{ $inv->number }}</td><td>{{ $inv->project?->name }}</td><td>${{ $inv->amount }}</td><td>{{ $inv->status }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
  <div class="mt-4">{{ $invoices->links() }}</div>
</div>
@endsection
