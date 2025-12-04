<section class="mb-4">

    <h4>Profile Information</h4>

    <p class="text-muted">
        Update your account's profile information and email address.
    </p>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-3">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input 
                id="name"
                name="name"
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', auth()->user()->name) }}"
                required
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input 
                id="email"
                name="email"
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', auth()->user()->email) }}"
                required
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Save Button --}}
        <button class="btn btn-primary">Save</button>

        {{-- Success Message --}}
        @if (session('status') === 'profile-updated')
            <span class="text-success ms-3">Profile updated.</span>
        @endif
    </form>

</section>
