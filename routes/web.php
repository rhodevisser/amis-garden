<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register-key', function () {
    return view('register-key');
});

Route::get('/login', function () {
    return view('login');
});


