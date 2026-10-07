<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Models\Photo;
use App\Models\User;
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
