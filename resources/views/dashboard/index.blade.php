@extends('layouts.app')

@section('title','Dashboard')

@section('header-actions')
  <a href="{{ route('projects.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded">+ Add New Project</a>
@endsection

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
  <div class="bg-white p-4 rounded shadow">
    <div class="text-sm text-gray-500">Clients</div>
    <div class="text-2xl font-bold">{{ $clients }}</div>
  </div>

  <div class="bg-white p-4 rounded shadow">
    <div class="text-sm text-gray-500">Projects</div>
    <div class="text-2xl font-bold">{{ $projects }}</div>
  </div>

  <div class="bg-white p-4 rounded shadow">
    <div class="text-sm text-gray-500">Tasks Completed</div>
    <div class="text-2xl font-bold">{{ $tasksCompleted }}</div>
    <div class="text-xs text-yellow-600 mt-1">{{ $pendingTasks }} pending</div>
  </div>

  <div class="bg-white p-4 rounded shadow">
    <div class="text-sm text-gray-500">Invoices Total</div>
    <div class="text-2xl font-bold">${{ number_format($invoicesTotal,2) }}</div>
  </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  <div class="bg-white p-4 rounded shadow">
    <h3 class="font-semibold mb-2">Performance Overview</h3>
    <div class="h-40 border rounded flex items-center justify-center text-gray-400">Chart area</div>
  </div>

  <div class="bg-white p-4 rounded shadow">
    <h3 class="font-semibold mb-2">Recent Projects</h3>
    <ul>
      @foreach($recentProjects as $rp)
        <li class="py-2 border-b">
          <div class="font-medium">{{ $rp->name }}</div>
          <div class="text-sm text-gray-600">{{ $rp->client?->name ?? 'No client' }} • {{ $rp->status }}</div>
        </li>
      @endforeach
    </ul>
  </div>
</div>
@endsection
