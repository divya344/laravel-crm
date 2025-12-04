@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<h2>Create Your Account 🚀</h2>

<form method="POST" action="{{ route('register.post') }}">
  @csrf

  @if(session('error'))
      <div class="alert alert-danger text-start">{{ session('error') }}</div>
  @endif

  <div class="mb-3 text-start">
    <label class="form-label fw-medium">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
  </div>

  <div class="mb-3 text-start">
    <label class="form-label fw-medium">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
  </div>

  <div class="mb-3 text-start">
    <label class="form-label fw-medium">Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>

  <div class="mb-3 text-start">
    <label class="form-label fw-medium">Confirm Password</label>
    <input type="password" name="password_confirmation" class="form-control" required>
  </div>

  <button type="submit" class="btn btn-primary w-100 mt-2">Register</button>
</form>
@endsection

@section('footer')
Already have an account? <a href="{{ route('login') }}">Login here</a>
@endsection
