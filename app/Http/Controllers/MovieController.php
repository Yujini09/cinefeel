<?php

namespace App\Http\Controllers;

use App\Http\Models\Genre;
use App\Http\Models\Movie;
use App\Http\Models\Mood;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Movie::with(['mood', 'genres']);

        // Handle sorting
        $sort = request('sort');
        switch ($sort) {
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'release_year':
                $query->orderBy('release_year', 'desc');
                break;
            case 'mood':
                $query->join('moods', 'movies.mood_id', '=', 'moods.id')
                      ->orderBy('moods.name', 'asc')
                      ->select('movies.*');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $movies = $query->paginate(12);
        return view('admin.movies', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $moods = Mood::all();
        $genres = Genre::all();
        return view('admin.movies', compact('moods', 'genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request)
    {
        $validated = $request->validated();

        $movie = Movie::create($validated);
        $movie->genres()->sync($request->genres ?? []);

        return redirect()->route('admin.movies.index')->with('success', 'Movie created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        $movie->load(['mood', 'genres']);
        return view('admin.movies', compact('movie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        $moods = Mood::all();
        $genres = Genre::all();
        $movie->load(['genres']);
        return view('admin.movies', compact('movie', 'moods', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        $validated = $request->validated();

        $movie->update($validated);
        $movie->genres()->sync($request->genres ?? []);

        return redirect()->route('admin.movies.index')->with('success', 'Movie updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $movie->genres()->detach();
        $movie->delete();

        return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully.');
    }
}
