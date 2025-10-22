<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use App\Models\Movie;
use App\Models\Genre;

class AdminController extends Controller
{
    public function dashboard()
    {
        $moviesCount = Movie::count();
        $moodsCount = Mood::count();

        // Featured Movies for the dashboard table (using inRandomOrder() as per original logic)
        $recentMovies = Movie::with(['mood', 'genres'])->inRandomOrder()->limit(5)->get();

        return view('admin.dashboard', compact('moviesCount', 'moodsCount', 'recentMovies'));
    }

    public function manageMovies()
    {
        $movies = Movie::with(['mood', 'genres'])->get();
        $moods = Mood::orderBy('mood_name')->get();
        $genres = Genre::orderBy('genre_name')->get();

        return view('admin.movies', compact('movies', 'moods', 'genres'));
    }

    public function manageMoods()
    {
        $moods = Mood::orderBy('mood_name')->get();
        $genres = Genre::orderBy('genre_name')->get();

        return view('admin.moods', compact('moods', 'genres'));
    }
}
