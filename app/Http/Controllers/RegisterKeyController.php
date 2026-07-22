<?php

namespace App\Http\Controllers;

use App\Models\Key;
use Illuminate\Http\Request;

class RegisterKeyController extends Controller
{
    /**
     * Handle the incoming request to validate a registration key
     *
     * This controller checks if the key entered by the user is valid
     * If valid, store it in the session and redirect to registration form
     * If invalid, redirect back with an error message
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255',
        ]);

        $key = Key::where('key', $validated['key'])->first();

        if (!$key) {
            return back()->withErrors([
                'key' => 'This registration key is not valid.',
            ])->withInput();
        }

        if (!$key->isValid()) {
            if ($key->isUsed()) {
                $errorMessage = 'This registration key has already been used.';
            } else {
                $errorMessage = 'This registration key has expired.';
            }

            return back()->withErrors([
                'key' => $errorMessage,
            ])->withInput();
        }

        $request->session()->put('registration_key_id', $key->id);

        return redirect()->route('register.form')
            ->with('success', 'Key validated! Please complete your registration.');
    }
}
