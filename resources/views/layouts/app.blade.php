<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ config('app.name','GrowCRM') }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body{padding-top:56px;background:#f4f6f9}
    .sidebar{min-height:100vh;background:#2f3659;color:#fff}
    .sidebar .nav-link{color:rgba(255,255,255,0.9)}
    .sidebar .nav-link.active{background:#1f2a44}
    .card {border-radius:6px}
    .topbar-badge{background:#ff6b6b;color:#fff;padding:3px 8px;border-radius:20px;font-size:12px}
    @media (max-width:767px){ .sidebar{display:none} }
  </style>
</head>
<body>
<nav class="navbar navbar-expand navbar-dark bg-primary fixed-top">
  <a class="navbar-brand" href="{{ route('dashboard') }}"><i class="fa-solid fa-leaf"></i> GrowCRM</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav ml-auto">
      @auth
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="userMenu" data-toggle="dropdown">{{ auth()->user()->name }}</a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenu">
            <a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a>
            <a class="dropdown-item" href="{{ route('chat.index') }}">Chat</a>
            <a class="dropdown-item" href="{{ route('files.index') }}">My Files</a>
            <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}" class="px-3">
              @csrf
              <button class="btn btn-sm btn-danger">Logout</button>
            </form>
          </div>
        </li>
      @else
        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
      @endauth
    </ul>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block sidebar p-3">
      <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="fa fa-tachometer-alt mr-2"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}" href="{{ route('clients.index') }}"><i class="fa fa-users mr-2"></i> Clients</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}" href="{{ route('projects.index') }}"><i class="fa fa-folder-open mr-2"></i> Projects</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}" href="{{ route('tasks.index') }}"><i class="fa fa-tasks mr-2"></i> Tasks</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}" href="{{ route('invoices.index') }}"><i class="fa fa-file-invoice-dollar mr-2"></i> Invoices</a></li>
        <li class="nav-item mt-2"><strong class="text-muted">Sales</strong></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('estimates.*') ? 'active' : '' }}" href="{{ route('estimates.index') }}"><i class="fa fa-receipt mr-2"></i> Estimates</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('leads.*') ? 'active' : '' }}" href="{{ route('leads.index') }}"><i class="fa fa-user-plus mr-2"></i> Leads</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}" href="{{ route('payments.index') }}"><i class="fa fa-credit-card mr-2"></i> Payments</a></li>

        <li class="nav-item mt-2"><strong class="text-muted">Collaboration</strong></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('chat.*') ? 'active' : '' }}" href="{{ route('chat.index') }}"><i class="fa fa-comments mr-2"></i> Chat</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('files.*') ? 'active' : '' }}" href="{{ route('files.index') }}"><i class="fa fa-folder-open mr-2"></i> My Files</a></li>

        <li class="nav-item mt-2"><strong class="text-muted">Support</strong></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('tickets.*') ? 'active' : '' }}" href="{{ route('tickets.index') }}"><i class="fa fa-life-ring mr-2"></i> Tickets</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('contracts.*') ? 'active' : '' }}" href="{{ route('contracts.index') }}"><i class="fa fa-file-contract mr-2"></i> Contracts</a></li>
        @auth
          @if(auth()->user()->role === 'admin')
            <li class="nav-item mt-3"><strong class="text-muted">Admin</strong></li>
            <li class="nav-item"><a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}"><i class="fa fa-user-shield mr-2"></i> Users</a></li>
          @endif
        @endauth
      </ul>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 py-4">
      @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
      @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
      @yield('content')
    </main>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
