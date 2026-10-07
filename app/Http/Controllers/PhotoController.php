<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Models\Comment;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index(Request $request)
    {
        return view('photos.index', [
            'photos' => Photo::latest()
                ->with('user')
                ->withCount('snacks')
                ->withExists($this->snackedByCurrentUser($request->user()))
                ->get(),
        ]);
    }

    public function show(Request $request, Photo $photo)
    {
        return view('photos.show', [
            'photo' => $photo->load('user')
                ->loadCount('snacks')
                ->loadExists($this->snackedByCurrentUser($request->user())),
            'comments' => $this->threadFor($photo, $request->user()),
        ]);
    }

    /**
     * Existence constraint that flags whether the given user already snacked the photo.
     *
     * @return array<string, \Closure>
     */
    private function snackedByCurrentUser(User $user): array
    {
        return [
            'snacks as snacked_by_current_user' => fn ($query) => $query->whereBelongsTo($user),
        ];
    }

    /**
     * Existence constraint that flags whether the given user already liked a comment.
     *
     * @return array<string, \Closure>
     */
    private function likedByCurrentUser(User $user): array
    {
        return [
            'likes as liked_by_current_user' => fn ($query) => $query->whereBelongsTo($user),
        ];
    }

    /**
     * Load the photo's comment thread with its replies.
     *
     * Soft-deleted root comments are kept so their surviving replies stay
     * nested; a tombstone without replies is dropped so deletions leave no
     * litter behind. Replies rely on the default soft-delete scope, which
     * already hides deleted ones.
     *
     * @return Collection<int, Comment>
     */
    private function threadFor(Photo $photo, User $user): Collection
    {
        return $photo->comments()
            ->withTrashed()
            ->root()
            ->with([
                'user',
                'replies' => fn ($query) => $query
                    ->with('user')
                    ->withCount('likes')
                    ->withExists($this->likedByCurrentUser($user))
                    ->oldest(),
            ])
            ->withCount('likes')
            ->withExists($this->likedByCurrentUser($user))
            ->oldest()
            ->get()
            ->reject(fn (Comment $comment) => $comment->trashed() && $comment->replies->isEmpty())
            ->values();
    }

    public function store(StorePhotoRequest $request)
    {
        $validated = $request->validated();

        $path = $request->file('photo')->store('photos');

        $request->user()->photos()->create([
            'title' => $validated['title'],
            'alt' => $validated['alt'],
            'description' => $validated['description'],
            'src' => $path,
        ]);

        return redirect()->route('photos.index');
    }

    public function edit(Photo $photo)
    {
        $this->authorize('update', $photo);

        return view('photos.edit', [
            'photo' => $photo,
        ]);
    }

    public function update(UpdatePhotoRequest $request, Photo $photo)
    {
        $this->authorize('update', $photo);

        $validated = $request->validated();

        if ($request->hasFile('photo')) {
            $validated['src'] = $request->file('photo')->store('photos');
        }

        $photo->update($validated);

        return redirect()->route('photos.show', $photo);
    }

    public function destroy(Photo $photo)
    {
        $this->authorize('delete', $photo);

        $photo->delete();

        return redirect()->route('photos.index');
    }
}
