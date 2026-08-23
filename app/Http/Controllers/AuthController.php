<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $attributes = $request->validate([]);

       if (! auth()->attempt($attributes)) {
           throw ValidationException::withMessages([
               'email' => 'Your provided credentials could not be verified.'
           ]);
       }
        $request->session()->regenerate();

        return redirect('/login');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
