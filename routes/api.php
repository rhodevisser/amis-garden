<?php

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
});
