<x-layout>
    <h1>Complete Your Registration</h1>

    {{-- Show success message from key validation --}}
    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Show validation errors if any --}}
    @if ($errors->any())
        <div class="error">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Optional: Display the key being used (for confirmation) --}}
    <p style="color: #666; margin-bottom: 20px;">
        Using registration key: <strong>{{ $key->key }}</strong>
    </p>

    {{-- The registration form --}}
    <form method="POST" action="{{ route('register.submit') }}">
        @csrf

        {{-- Name field --}}
        <div class="form-control">
            <label class="label" for="name">
                <span class="label-text">Full Name</span>
            </label>
            {{-- old('name') keeps the value if validation fails --}}
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="Enter your full name"
                class="input input-bordered"
                required
                autofocus
            >
        </div>

        {{-- Email field --}}
        <div class="form-control">
            <label class="label" for="email">
                <span class="label-text">Email Address</span>
            </label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="your.email@example.com"
                class="input input-bordered"
                required
            >
        </div>

        {{-- Password field --}}
        <div class="form-control">
            <label class="label" for="password">
                <span class="label-text">Password</span>
            </label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Minimum 8 characters"
                class="input input-bordered"
                required
            >
            <label class="label">
                <span class="label-text-alt">Password must be at least 8 characters long.</span>
            </label>
        </div>

        {{-- Password confirmation field --}}
        {{-- Laravel checks that this matches the 'password' field (because we used 'confirmed' in validation) --}}
        <div class="form-control">
            <label class="label" for="password_confirmation">
                <span class="label-text">Confirm Password</span>
            </label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="Re-enter your password"
                class="input input-bordered"
                required
            >
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">Create Account</button>
            {{-- Link back to key validation in case they want to use a different key --}}
            <a href="{{ route('register.key') }}" style="margin-left: 10px;">
                <button type="button" class="btn btn-secondary">Use Different Key</button>
            </a>
        </div>
    </form>
</x-layout>
