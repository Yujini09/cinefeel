<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;

    Route::get('/', [PublicController::class, 'home'])->name('home'); // cinefeel react js/index.php
    Route::get('/mood-selection', [PublicController::class, 'moodSelection'])->name('mood.selection'); // cinefeel react js/mood-selection.php
    Route::post('/recommendations', [PublicController::class, 'recommendations'])->name('recommendations'); // cinefeel react js/recommendations.php

    // Admin Routes (Grouped for potential middleware/prefixing later)
    Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard'); // cinefeel react js/admin/index.php
    Route::get('/movies', [AdminController::class, 'manageMovies'])->name('movies'); // cinefeel react js/admin/movies.php
    Route::get('/moods', [AdminController::class, 'manageMoods'])->name('moods'); // cinefeel react js/admin/moods.php
});
