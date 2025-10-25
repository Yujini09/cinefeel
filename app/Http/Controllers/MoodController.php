<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use App\Http\Requests\StoreMoodRequest;
use App\Http\Requests\UpdateMoodRequest;

class MoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $moods = Mood::all();
        return view('moods.index', compact('moods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('moods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMoodRequest $request)
    {
        $validated = $request->validated();

        Mood::create($validated);

        return redirect()->route('moods.index')->with('success', 'Mood created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mood $mood)
    {
        return view('moods.show', compact('mood'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mood $mood)
    {
        return view('moods.edit', compact('mood'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMoodRequest $request, Mood $mood)
    {
        $validated = $request->validated();

        $mood->update($validated);

        return redirect()->route('moods.index')->with('success', 'Mood updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mood $mood)
    {
        $mood->delete();

        return redirect()->route('moods.index')->with('success', 'Mood deleted successfully.');
    }
}
