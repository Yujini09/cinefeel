<?php

namespace App\Http\Controllers;

use App\Http\Models\Mood;
use App\Http\Models\Movie;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // Corresponds to cinefeel react js/index.php
    public function home()
    {
        $featuredMovies = Movie::with(['mood', 'genres'])->inRandomOrder()->limit(8)->get();
        $moods = Mood::orderBy('mood_name')->get();

        return view('public.home', compact('featuredMovies', 'moods'));
    }

    // Corresponds to cinefeel react js/mood-selection.php
    public function moodSelection()
    {
        $moods = Mood::orderBy('mood_name')->get();
        return view('public.mood-selection', compact('moods'));
    }

    // Corresponds to cinefeel react js/recommendations.php
    public function recommendations(Request $request)
    {
        $moodId = $request->input('mood_id');
        $mood = Mood::find($moodId);

        if (!$mood) {
            return redirect()->route('mood.selection')->with('error', 'Invalid mood selected.');
        }

        // Fetch movies associated with the mood, eager loading relationships
        $movies = Movie::where('mood_id', $moodId)
            ->with(['mood', 'genres'])
            ->get();

        return view('public.recommendations', compact('mood', 'movies'));
    }
}
