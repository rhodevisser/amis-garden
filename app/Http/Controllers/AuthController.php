<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

       if (! auth()->attempt($request->validated(), $request->boolean('remember'))) {
           throw ValidationException::withMessages([
               'email' => __('auth.failed'),
           ]);
       }
        $request->session()->regenerate();

        return redirect('/');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
