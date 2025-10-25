<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use App\Models\Movie;
use App\Http\Requests\MoodSelectionRequest;

class HomeController extends Controller
{
    public function index()
    {
        $featuredMovies = Movie::inRandomOrder()->take(6)->get();
        $moods = Mood::all();

        return view('home', compact('featuredMovies', 'moods'));
    }

    public function moodSelection()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $moods = Mood::all();

        return view('mood-selection', compact('moods'));
    }

    public function recommendations(MoodSelectionRequest $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $validated = $request->validated();

        $moodId = $validated['mood_id'];
        $mood = Mood::find($moodId);

        if (!$mood) {
            return redirect()->route('mood.selection');
        }

        $movies = Movie::where('mood_id', $moodId)->with('genres')->get();

        return view('recommendations', compact('mood', 'movies'));
    }
}
