<?php

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/')->with('success', 'Goodbye!');
})->middleware('web');
