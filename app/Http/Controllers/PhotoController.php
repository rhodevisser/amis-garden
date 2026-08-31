<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Models\Photo;

class PhotoController extends Controller
{
    public function index()
    {
        return view('photos.index', [
            'photos' => Photo::newest()->with('user')->get(),
        ]);
    }

    public function show(Photo $photo)
    {
        return view('photos.show', [
            'photo' => $photo->load('user'),
        ]);
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
