@extends('layouts.app')
@section('content')
<h1>Dashboard</h1>
<div class="row">
  <div class="col-md-3"><div class="card p-3"><h5>Clients</h5><h3>{{ $clients }}</h3></div></div>
  <div class="col-md-3"><div class="card p-3"><h5>Projects</h5><h3>{{ $projects }}</h3></div></div>
  <div class="col-md-3"><div class="card p-3"><h5>Tasks Completed</h5><h3>{{ $tasksCompleted }}</h3></div></div>
  <div class="col-md-3"><div class="card p-3"><h5>Invoices Total</h5><h3>${{ number_format($invoicesTotal,2) }}</h3></div></div>
</div>
<div class="row mt-3">
  <div class="col-md-3"><div class="card p-3"><h6>Estimates</h6><p>{{ $estimates }}</p></div></div>
  <div class="col-md-3"><div class="card p-3"><h6>Leads</h6><p>{{ $leads }}</p></div></div>
  <div class="col-md-3"><div class="card p-3"><h6>Open Tickets</h6><p>{{ $ticketsOpen }}</p></div></div>
  <div class="col-md-3"><div class="card p-3"><h6>Payments Total</h6><p>${{ number_format($paymentsTotal,2) }}</p></div></div>
</div>

<div class="row mt-4">
  <div class="col-12">
    <canvas id="dashboardChart" height="100"></canvas>
  </div>
</div>

<h3 class="mt-4">Recent Projects</h3>
<ul class="list-group">
@foreach($recentProjects as $rp)
  <li class="list-group-item">{{ $rp->name }} - {{ $rp->client?->name ?? 'No client' }}</li>
@endforeach
</ul>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  const ctx = document.getElementById('dashboardChart').getContext('2d');
  const data = {
    labels: ['Clients','Projects','Leads','Estimates','InvoicesCount'],
    datasets: [{
      label: 'Counts',
      data: [{{ $clients }}, {{ $projects }}, {{ $leads }}, {{ $estimates }}, {{ $invoicesTotal ? 1 : 0 }}],
    }]
  };
  new Chart(ctx, {type:'bar', data: data});
});
</script>
@endpush
