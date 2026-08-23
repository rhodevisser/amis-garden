<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegisterKeyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register/key', function () {
    return view('register.key');
});
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function () {
    $attributes = request()->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (! auth()->attempt($attributes)) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => 'Your provided credentials could not be verified.'
        ]);
    }

    session()->regenerate();

    return redirect('/')->with('success', 'Welcome back!');
});

Route::get('/register', function () {
    return view('register.key');
})->name('register.key');
Route::post('/register/validate-key', RegisterKeyController::class)
    ->name('register.validate-key');
Route::middleware('registration.key')->group(function () {
    Route::get('/register/form', [RegisterController::class, 'showRegistrationForm'])
        ->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])
        ->name('register.submit');
});
