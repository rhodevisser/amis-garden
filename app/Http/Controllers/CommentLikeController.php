<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    /**
     * Toggle the authenticated user's like on the given comment.
     *
     * A user can like a comment at most once, so a second request
     * removes the existing like instead of adding another one.
     */
    public function __invoke(Request $request, Comment $comment): RedirectResponse
    {
        $like = $comment->likes()->whereBelongsTo($request->user())->first();

        if ($like) {
            $like->delete();
        } else {
            $comment->likes()->create([
                'user_id' => $request->user()->id,
            ]);
        }

        return back();
    }
}
