<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PhotoSnackController extends Controller
{
    /**
     * Toggle the authenticated user's snack (🐟) on the given photo.
     *
     * A user can give at most one snack per photo, so a second request
     * removes the existing snack instead of adding another one.
     */
    public function __invoke(Request $request, Photo $photo): RedirectResponse
    {
        $snack = $photo->snacks()->whereBelongsTo($request->user())->first();

        if ($snack) {
            $snack->delete();
        } else {
            $photo->snacks()->create([
                'user_id' => $request->user()->id,
            ]);
        }

        return back();
    }
}
