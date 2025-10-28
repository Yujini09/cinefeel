<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/mood-selection', [HomeController::class, 'moodSelection'])->name('mood.selection')->middleware('auth');
Route::post('/recommendations', [HomeController::class, 'recommendations'])->name('recommendations')->middleware('auth');
Route::post('/submit-review', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');

// Authentication routes
Route::get('/login', [AuthController::class, 'showUserLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User registration routes
Route::get('/register', [AuthController::class, 'showUserRegister'])->name('register');
Route::post('/register', [AuthController::class, 'registerUser'])->name('register.post');

// Admin authentication routes
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::get('/admin/register', [AuthController::class, 'showAdminRegister'])->name('admin.register')->middleware('admin');
Route::post('/admin/register', [AuthController::class, 'registerAdmin'])->name('admin.register.post')->middleware('admin');

// Social login routes
Route::get('/auth/facebook', [AuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [AuthController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('movies', MovieController::class)->names([
        'index' => 'admin.movies.index',
        'create' => 'admin.movies.create',
        'store' => 'admin.movies.store',
        'show' => 'admin.movies.show',
        'edit' => 'admin.movies.edit',
        'update' => 'admin.movies.update',
        'destroy' => 'admin.movies.delete',
    ]);
    Route::resource('moods', MoodController::class)->names([
        'index' => 'admin.moods.index',
        'create' => 'admin.moods.create',
        'store' => 'admin.moods.store',
        'show' => 'admin.moods.show',
        'edit' => 'admin.moods.edit',
        'update' => 'admin.moods.update',
        'destroy' => 'admin.moods.destroy',
    ]);
    Route::resource('reviews', \App\Http\Controllers\ReviewController::class)->names([
        'index' => 'admin.reviews.index',
        'create' => 'admin.reviews.create',
        'store' => 'admin.reviews.store',
        'show' => 'admin.reviews.show',
        'edit' => 'admin.reviews.edit',
        'update' => 'admin.reviews.update',
        'destroy' => 'admin.reviews.destroy',
    ]);
});

Route::resource('moods', MoodController::class);
Route::resource('movies', MovieController::class);
