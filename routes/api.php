<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MovieApiController;
use App\Http\Controllers\Api\MoodApiController;

Route::post('movies', [MovieApiController::class, 'store']);       // maps to action=add_movie
Route::put('movies/{movie}', [MovieApiController::class, 'update']); // maps to action=update_movie
Route::delete('movies/{movie}', [MovieApiController::class, 'destroy']); // maps to action=delete_movie

Route::post('moods', [MoodApiController::class, 'store']);        // maps to action=add_mood
Route::put('moods/{mood}', [MoodApiController::class, 'update']);  // maps to action=update_mood
Route::delete('moods/{mood}', [MoodApiController::class, 'destroy']); // maps to action=delete_mood
