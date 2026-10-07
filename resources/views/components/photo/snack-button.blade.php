@props(['photo'])

<form action="{{ route('photos.snack', $photo) }}" method="POST">
    @csrf
    <button
        type="submit"
        aria-pressed="{{ $photo->snacked_by_current_user ? 'true' : 'false' }}"
        aria-label="{{ $photo->snacked_by_current_user ? 'Take back your snack' : 'Give this photo a snack' }}"
        class="btn btn-sm gap-2 rounded-2xl border-none font-bold {{ $photo->snacked_by_current_user ? 'bg-pink-500 hover:bg-pink-600 text-white' : 'bg-pink-100 hover:bg-pink-200 text-pink-600' }}"
    >
        <span aria-hidden="true">&#128031;</span>
        <span>{{ $photo->snacks_count }}</span>
    </button>
</form>
