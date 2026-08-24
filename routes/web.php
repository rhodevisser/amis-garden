<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegisterKeyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register/key', function () {
    return view('register.key');
});
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('register')->name('register.')->group(function () {
    Route::get('/', function () {
        return view('register.key');
    })->name('key');

    Route::post('/validate-key', RegisterKeyController::class)
        ->name('validate-key');

    Route::middleware('registration.key')->group(function () {
        Route::get('/form', [RegisterController::class, 'showRegistrationForm'])
            ->name('form');
        Route::post('/', [RegisterController::class, 'register'])
            ->name('submit');
    });
});
