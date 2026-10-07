@props(['photo', 'parent' => null])

<form action="{{ route('comments.store', $photo) }}" method="POST" class="space-y-3">
    @csrf
    @if ($parent)
        <input type="hidden" name="parent_id" value="{{ $parent->id }}" />
    @endif

    <textarea
        name="content"
        rows="{{ $parent ? 2 : 3 }}"
        required
        maxlength="1000"
        placeholder="{{ $parent ? 'Write a reply...' : 'Leave a comment...' }}"
        aria-label="{{ $parent ? 'Your reply' : 'Your comment' }}"
        class="textarea textarea-bordered w-full rounded-2xl"
    ></textarea>

    <button type="submit" class="btn btn-sm bg-pink-500 hover:bg-pink-600 border-none text-white rounded-2xl font-bold">
        {{ $parent ? 'Post reply' : 'Post comment' }}
    </button>
</form>
