<?php

namespace App\Http\Controllers;

use App\Http\Models\Mood;
use App\Http\Models\Movie;
use App\Http\Models\Review; // <-- NEW: Import the Review Model
use App\Http\Requests\MoodSelectionRequest;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch data for the home page
        $featuredMovies = Movie::inRandomOrder()->take(6)->get();
        $moods = Mood::all();
        
        // NEW: Fetch the latest reviews for the Testimonials section
        // We'll fetch 5 reviews, ordered by creation date (newest first)
        $reviews = Review::latest()->take(5)->get(); 

        return view('home', compact('featuredMovies', 'moods', 'reviews')); // <-- NEW: Pass 'reviews' to the view
    }

    public function moodSelection()
    {
        $moods = Mood::all();
        return view('mood-selection', compact('moods'));
    }

    public function recommendations(MoodSelectionRequest $request)
    {
        $validated = $request->validated();
        $moodId = $validated['mood_id'];
        $mood = Mood::find($moodId);

        if (!$mood) {
            return redirect()->route('mood.selection')->with('error', 'Invalid mood selected.');
        }

        $movies = Movie::where('mood_id', $moodId)->with('genres')->get();

        return view('recommendations', compact('mood', 'movies'));
    }

    // (You can remove the commented-out methods below the main logic)
}