<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/mood-selection', [HomeController::class, 'moodSelection'])->name('mood.selection');
Route::post('/recommendations', [HomeController::class, 'recommendations'])->name('recommendations');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Facebook login
Route::get('/auth/facebook', [AuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [AuthController::class, 'handleFacebookCallback']);

// Admin routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/create-admin', [AdminController::class, 'createAdmin'])->name('admin.create');
    Route::delete('/delete-admin/{id}', [AdminController::class, 'deleteAdmin'])->name('admin.delete');
});

Route::resource('moods', MoodController::class);
Route::resource('movies', MovieController::class);
