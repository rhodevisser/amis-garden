<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Models\Pet;

class PetController extends Controller
{
    public function create()
    {
        return view('pets.create');
    }

    public function store(StorePetRequest $request)
    {
        $validated = $request->validated();

        $path = $request->file('image')->store('pets', 'public');

        $request->user()->pets()->create([
            'name' => $validated['name'],
            'species' => $validated['species'],
            'breed' => $validated['breed'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'description' => $validated['description'],
            'image' => $path,
        ]);

        return redirect()->route('user.show', $request->user())->with('success', 'Pet added successfully!');
    }

    public function show(Pet $pet)
    {
        return view('pets.show', [
            'pet' => $pet->load('owner', 'coOwners'),
        ]);
    }

    public function edit(Pet $pet)
    {
        $this->authorize('update', $pet);

        return view('pets.edit', [
            'pet' => $pet,
        ]);
    }

    public function update(UpdatePetRequest $request, Pet $pet)
    {
        $this->authorize('update', $pet);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('pets', 'public');
        } else {
            unset($validated['image']);
        }

        $pet->update($validated);

        return redirect()->route('pets.show', $pet)->with('success', 'Pet updated successfully!');
    }

    public function destroy(Pet $pet)
    {
        $this->authorize('delete', $pet);

        $pet->delete();

        return redirect()->route('user.show', $pet->owner)->with('success', 'Pet removed successfully!');
    }
}
