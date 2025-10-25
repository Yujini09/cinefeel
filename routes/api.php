<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Facebook login API route
Route::get('/auth/facebook', function () {
    return redirect()->away('https://www.facebook.com/v18.0/dialog/oauth?client_id=' . config('services.facebook.client_id') . '&redirect_uri=' . urlencode(config('services.facebook.redirect')) . '&scope=email,public_profile');
});
