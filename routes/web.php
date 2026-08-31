<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegisterKeyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});
Route::post('/login', [AuthController::class, 'login']);
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

Route::middleware('auth')->group(function () {
    Route::get('/profile/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/profile/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::patch('/profile/{user}', [UserController::class, 'update'])->name('user.update');

    Route::get('/photos', [PhotoController::class, 'index'])->name('photos.index');
    Route::post('/photos', [PhotoController::class, 'store'])->name('photos.store');
    Route::get('/photos/{photo}', [PhotoController::class, 'show'])->name('photos.show');
    Route::get('/photos/{photo}/edit', [PhotoController::class, 'edit'])->name('photos.edit');
    Route::patch('/photos/{photo}', [PhotoController::class, 'update'])->name('photos.update');
    Route::delete('/photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');
});

