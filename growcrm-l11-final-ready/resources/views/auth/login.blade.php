@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<h2>Welcome Back 👋</h2>

<form method="POST" action="{{ route('login.post') }}">
  @csrf

  @if(session('error'))
      <div class="alert alert-danger text-start">{{ session('error') }}</div>
  @endif

  <div class="mb-3 text-start">
    <label class="form-label fw-medium">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
  </div>

  <div class="mb-3 text-start">
    <label class="form-label fw-medium">Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>

  <button type="submit" class="btn btn-primary w-100 mt-2">Login</button>
</form>
@endsection

@section('footer')
Don’t have an account? <a href="{{ route('register') }}">Register here</a>
@endsection
