@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Dashboard</h1>
  @auth
    @if(auth()->user()->role === 'admin')
      <a href="{{ route('users.create') }}" class="btn btn-success"><i class="fa fa-user-plus"></i> New User</a>
    @endif
  @endauth
</div>

<div class="row">
  <div class="col-md-3"><div class="card p-3"><small class="text-muted">Clients</small><h3>{{ $clients }}</h3></div></div>
  <div class="col-md-3"><div class="card p-3"><small class="text-muted">Projects</small><h3>{{ $projects }}</h3></div></div>
  <div class="col-md-3"><div class="card p-3"><small class="text-muted">Invoices</small><h3>{{ $invoicesCount }} • ${{ number_format($invoicesTotal,2) }}</h3></div></div>
  <div class="col-md-3"><div class="card p-3"><small class="text-muted">Payments</small><h3>${{ number_format($paymentsTotal,2) }}</h3></div></div>
</div>

<div class="row mt-4">
  <div class="col-md-4"><div class="card p-3"><h6>Projects by Status</h6><canvas id="projectsStatusChart"></canvas></div></div>
  <div class="col-md-4"><div class="card p-3"><h6>Tasks Progress</h6><canvas id="tasksProgressChart"></canvas></div></div>
  <div class="col-md-4"><div class="card p-3"><h6>Revenue (last months)</h6><canvas id="revenueChart"></canvas></div></div>
</div>

<h4 class="mt-4">Recent Projects</h4>
<div class="list-group">
  @foreach($recentProjects as $rp)
    <a class="list-group-item list-group-item-action" href="{{ route('projects.show', $rp) }}">{{ $rp->name }} <small class="text-muted">({{ $rp->client?->name ?? 'No client' }})</small></a>
  @endforeach
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  // Projects by status
  const projectsData = {!! json_encode($projectsByStatus) !!};
  const labelsP = Object.keys(projectsData);
  const valuesP = Object.values(projectsData);

  new Chart(document.getElementById('projectsStatusChart'), {
    type: 'pie',
    data: { labels: labelsP, datasets:[{data: valuesP}] }
  });

  // Tasks progress
  const tasksData = [{{ $tasksPending }}, {{ $tasksInProgress }}, {{ $tasksCompleted }}];
  new Chart(document.getElementById('tasksProgressChart'), {
    type: 'doughnut',
    data: { labels: ['Pending','In Progress','Completed'], datasets:[{data: tasksData}] }
  });

  // Revenue
  const revenueObj = {!! json_encode($revenue) !!};
  const revLabels = Object.keys(revenueObj).reverse();
  const revValues = Object.values(revenueObj).reverse();
  new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: { labels: revLabels, datasets:[{ label:'Revenue', data: revValues, fill:false }] }
  });
});
</script>
@endpush
