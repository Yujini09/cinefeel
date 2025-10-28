<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Models\Movie;
use App\Http\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieApiController extends Controller
{
    // The previous 'add_movie' logic
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'genre' => 'required|string|max:255',
            'mood_id' => 'nullable|exists:moods,mood_id',
            'description' => 'nullable|string',
            'poster_url' => 'nullable|url|max:255',
            'trailer_link' => 'nullable|url|max:255',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'duration' => 'nullable|string|max:20',
        ]);

        $genre = Genre::where('genre_name', $validated['genre'])->first();
        if (!$genre) {
            // Note: The original PHP code threw a 400 error if the genre didn't exist. We keep this logic.
            return response()->json(['success' => false, 'message' => 'Invalid genre. Please select an existing genre from the list.'], 400);
        }

        try {
            DB::beginTransaction();

            $movie = Movie::create([
                'title' => $validated['title'],
                'mood_id' => $validated['mood_id'],
                'description' => $validated['description'],
                'poster_url' => $validated['poster_url'],
                'trailer_link' => $validated['trailer_link'],
                'release_year' => $validated['release_year'],
                'duration' => $validated['duration'],
            ]);

            $movie->genres()->attach($genre->genre_id);

            DB::commit();

            $movie->load(['mood', 'genres']); // Load relationships for the response
            return response()->json(['success' => true, 'message' => 'Movie added successfully!', 'movie' => $movie], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to add movie: ' . $e->getMessage()], 500);
        }
    }

    // The previous 'update_movie' logic
    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'genre' => 'required|string|max:255',
            'mood_id' => 'nullable|exists:moods,mood_id',
            'description' => 'nullable|string',
            'poster_url' => 'nullable|url|max:255',
            'trailer_link' => 'nullable|url|max:255',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'duration' => 'nullable|string|max:20',
        ]);

        $genre = Genre::where('genre_name', $validated['genre'])->first();
        if (!$genre) {
            return response()->json(['success' => false, 'message' => 'Invalid genre. Please select an existing genre from the list.'], 400);
        }

        try {
            DB::beginTransaction();

            $movie->update([
                'title' => $validated['title'],
                'mood_id' => $validated['mood_id'],
                'description' => $validated['description'],
                'poster_url' => $validated['poster_url'],
                'trailer_link' => $validated['trailer_link'],
                'release_year' => $validated['release_year'],
                'duration' => $validated['duration'],
            ]);

            // Sync genre: detach all existing and attach the new one
            $movie->genres()->sync([$genre->genre_id]);

            DB::commit();

            $movie->load(['mood', 'genres']);
            return response()->json(['success' => true, 'message' => 'Movie updated successfully!', 'movie' => $movie]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to update movie: ' . $e->getMessage()], 500);
        }
    }

    // The previous 'delete_movie' logic
    public function destroy(Movie $movie)
    {
        try {
            $movie->genres()->detach(); // Remove pivot entries (optional due to CASCADE delete on DB)
            $movie->delete();

            return response()->json(['success' => true, 'message' => 'Movie deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete movie.'], 500);
        }
    }
}
