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

        <div class="form-group">
            <label for="key">Registration Key</label>
            <input
                type="text"
                id="key"
                name="key"
                value="{{ old('key') }}"
                placeholder="Enter your registration key"
                required
                autofocus
            >
            <small style="color: #666; display: block; margin-top: 5px;">
                You should have received this key personally.
            </small>
        </div>

        <button type="submit">Continue to Registration</button>
    </form>
</x-layout>
