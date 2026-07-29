<x-layout>
    <h1>Register for AmisGarden</h1>
    <p>Please enter your registration key to continue.</p>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register.validate-key') }}">
        @csrf

        <div class="form-control">
            <label class="label" for="key">
                <span class="label-text">Registration Key</span>
            </label>
            <input
                type="text"
                id="key"
                name="key"
                value="{{ old('key') }}"
                placeholder="Enter your registration key"
                class="input input-bordered"
                required
                autofocus
            >
            <label class="label">
                <span class="label-text-alt">You should have received this key personally.</span>
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Continue to Registration</button>
    </form>
</x-layout>
