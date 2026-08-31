<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
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

        $path = $request->file('photo')->store('photos', 'public');

        auth()->user()->photos()->create([
            'title' => $validated['title'],
            'alt' => $validated['alt'],
            'description' => $validated['description'],
            'src' => $path,
        ]);

        return redirect()->route('photos.index');
    }

    public function destroy(Photo $photo)
    {
        $photo->delete();

        return redirect()->route('photos.index');
    }
}
