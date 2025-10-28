<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Models\Mood;
use Illuminate\Http\Request;

class MoodApiController extends Controller
{
    // The previous 'add_mood' logic
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mood_name' => 'required|string|max:50|unique:moods,mood_name',
            'mapped_genre' => 'required|string|max:50',
            'emoji' => 'required|string|max:10',
            'description' => 'nullable|string',
        ]);

        $mood = Mood::create($validated);

        return response()->json(['success' => true, 'message' => 'Mood added successfully!', 'mood' => $mood], 201);
    }

    // The previous 'update_mood' logic
    public function update(Request $request, Mood $mood)
    {
        $validated = $request->validate([
            'mood_name' => 'required|string|max:50|unique:moods,mood_name,' . $mood->mood_id . ',mood_id',
            'mapped_genre' => 'required|string|max:50',
            'emoji' => 'required|string|max:10',
            'description' => 'nullable|string',
        ]);

        $mood->update($validated);

        return response()->json(['success' => true, 'message' => 'Mood updated successfully!', 'mood' => $mood]);
    }

    // The previous 'delete_mood' logic
    public function destroy(Mood $mood)
    {
        // Logic from Mood.php: Check if any movies use this mood
        if ($mood->movies()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete mood - it is associated with existing movies.'
            ], 409);
        }

        $mood->delete();
        return response()->json(['success' => true, 'message' => 'Mood deleted successfully!']);
    }
}
