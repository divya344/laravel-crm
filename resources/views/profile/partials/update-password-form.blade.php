<section class="mb-4">

    <h4>Update Password</h4>

    <p class="text-muted">
        Ensure your account is secured with a strong password.
    </p>

    <form method="POST" action="{{ route('profile.password') }}" class="mt-3">
        @csrf

        {{-- Current Password --}}
        <div class="mb-3">
            <label for="current_password" class="form-label">Current Password</label>
            <input type="password" name="current_password" id="current_password"
                   class="form-control @error('current_password') is-invalid @enderror">
            @error('current_password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- New Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" name="password" id="password"
                   class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="form-control @error('password_confirmation') is-invalid @enderror">
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Save Button --}}
        <button class="btn btn-primary">Save</button>

        {{-- Success Message --}}
        @if (session('status') === 'password-updated')
            <span class="text-success ms-3">Password updated.</span>
        @endif
    </form>

</section>
