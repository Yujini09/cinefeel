<?php

namespace App\Http\Controllers;

use App\Http\Models\Mood;
use App\Http\Models\Genre; // <-- ADD THIS IMPORT
use App\Http\Requests\StoreMoodRequest;
use App\Http\Requests\UpdateMoodRequest;

class MoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ... (Index logic remains the same)
        $query = Mood::query();

        // Handle sorting
        // ... (Sorting logic)

        $moods = $query->paginate(12);
        return view('admin.moods', compact('moods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = Genre::all(); // <-- FIXED: Fetch genres
        return view('admin.moods', compact('genres') + ['is_creating' => true]); // <-- FIXED: Pass genres
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMoodRequest $request)
    {
        $validated = $request->validated();

        Mood::create($validated);

        return redirect()->route('admin.moods.index')->with('success', 'Mood created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mood $mood)
    {
        $genres = Genre::all(); // Add genre for consistency with other views that may use it
        return view('admin.moods', compact('mood', 'genres'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mood $mood)
    {
        $genres = Genre::all(); // <-- FIXED: Fetch genres
        return view('admin.moods', compact('mood', 'genres')); // <-- FIXED: Pass genres
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMoodRequest $request, Mood $mood)
    {
        $validated = $request->validated();

        $mood->update($validated);

        return redirect()->route('admin.moods.index')->with('success', 'Mood updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mood $mood)
    {
        $mood->delete();

        return redirect()->route('admin.moods.index')->with('success', 'Mood deleted successfully.');
    }
}