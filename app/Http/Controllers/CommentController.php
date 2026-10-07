<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Photo;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    /**
     * Store a comment on the given photo, or a reply when `parent_id` is present.
     */
    public function store(StoreCommentRequest $request, Photo $photo): RedirectResponse
    {
        $validated = $request->validated();

        $photo->comments()->create([
            'user_id' => $request->user()->id,
            'parent_id' => $validated['parent_id'] ?? null,
            'content' => $validated['content'],
        ]);

        return back();
    }

    /**
     * Delete a comment or reply belonging to the authenticated user.
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back();
    }
}
