<?php

namespace App\Http\Controllers;

use App\Models\Key;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Show the registration form
     *
     * This page should only be accessible if the user has validated a key
     * We check the session for the registration_key_id
     */
    public function showRegistrationForm(Request $request)
    {
        if (!$request->session()->has('registration_key_id')) {
            return redirect()->route('register.key')->withErrors([
                'key' => 'Please enter a valid registration key first.',
            ]);
        }

        $keyId = $request->session()->get('registration_key_id');
        $key = Key::find($keyId);

        if (!$key || !$key->isValid()) {
            $request->session()->forget('registration_key_id');

            return redirect()->route('register.key')->withErrors([
                'key' => 'Your registration key is no longer valid. Please try again.',
            ]);
        }

        return view('register.register', ['key' => $key]);
    }

    /**
     * Handle the registration form submission
     *
     * This creates the user account and marks the key as used
     */
    public function register(Request $request)
    {
        if (!$request->session()->has('registration_key_id')) {
            return redirect()->route('register.key')->withErrors([
                'key' => 'Please enter a valid registration key first.',
            ]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => 'required|string|email|max:255|unique:users',

            'password' => 'required|string|min:8|confirmed',
        ]);

        $keyId = $request->session()->get('registration_key_id');
        $key = Key::find($keyId);

        if (!$key || !$key->isValid()) {
            $request->session()->forget('registration_key_id');

            return redirect()->route('register.key')->withErrors([
                'key' => 'Your registration key is no longer valid. Please try again.',
            ]);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);


        $key->update([
            'used_by' => $user->id,
            'used_at' => now(),
        ]);

        $request->session()->forget('registration_key_id');

        Auth::login($user);

        return redirect('/')->with('success', 'Registration successful! Welcome to AmisGarden.');
    }
}
