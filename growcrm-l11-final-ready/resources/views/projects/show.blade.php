@extends('layouts.app')

@section('title', $project->name)

@section('content')
<div class="bg-white p-4 rounded shadow">
  <h2 class="text-xl font-bold">{{ $project->name }}</h2>
  <div class="text-sm text-gray-600">Client: {{ $project->client?->name }}</div>
  <div class="mt-4">{{ $project->description }}</div>
</div>
@endsection
