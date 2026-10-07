@props(['comment', 'photo', 'isReply' => false])

<div class="bg-white rounded-2xl border-2 border-pink-100 p-4">
    @if ($comment->trashed())
        <p class="text-sm italic text-pink-300">[deleted]</p>
    @else
        <div class="flex items-baseline justify-between gap-3">
            <p class="text-sm font-bold text-pink-700">
                {{ $comment->user_id === auth()->id() ? 'You' : $comment->user->name }}
            </p>
            <p class="text-xs text-pink-300">{{ $comment->created_at->diffForHumans() }}</p>
        </div>

        <p class="text-sm text-pink-500 mt-2 whitespace-pre-line">{{ $comment->content }}</p>

        <div class="flex items-center gap-2 mt-3">
            <form action="{{ route('comments.like', $comment) }}" method="POST">
                @csrf
                <button
                    type="submit"
                    aria-pressed="{{ $comment->liked_by_current_user ? 'true' : 'false' }}"
                    aria-label="{{ $comment->liked_by_current_user ? 'Remove your like' : 'Like this comment' }}"
                    class="btn btn-xs gap-1 rounded-xl border-none font-bold {{ $comment->liked_by_current_user ? 'bg-pink-500 hover:bg-pink-600 text-white' : 'bg-pink-100 hover:bg-pink-200 text-pink-600' }}"
                >
                    <span aria-hidden="true">&#10084;&#65039;</span>
                    <span>{{ $comment->likes_count }}</span>
                </button>
            </form>

            @can('delete', $comment)
                <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs bg-red-100 hover:bg-red-200 border-none text-red-600 rounded-xl font-bold">
                        Delete
                    </button>
                </form>
            @endcan
        </div>

        @unless ($isReply)
            <details class="mt-3">
                <summary class="text-xs font-bold text-pink-400 hover:text-pink-600 cursor-pointer">Reply</summary>
                <div class="mt-3">
                    <x-comment.form :$photo :parent="$comment" />
                </div>
            </details>
        @endunless
    @endif
</div>
