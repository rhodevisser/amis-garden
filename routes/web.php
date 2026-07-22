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
});


/**
 * Registration Routes
 *
 * These routes handle the two-step registration process:
 * 1. User enters and validates their registration key
 * 2. User fills out registration form and creates account
 */

Route::get('/register', function () {
    return view('register.key');
})->name('register.key');
Route::post('/register/validate-key', RegisterKeyController::class)
    ->name('register.validate-key');
Route::get('/register/form', [RegisterController::class, 'showRegistrationForm'])
    ->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])
    ->name('register.submit');
