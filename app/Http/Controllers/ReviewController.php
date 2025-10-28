<?php

// app/Http/Controllers/ReviewController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Review; // Make sure to create this Model
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.reviews', compact('reviews'));
    }

    public function store(Request $request)
    {
        // 1. Validate the incoming data
        $validatedData = $request->validate([
            'reviewer_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'required|string|max:1000',
        ]);

        // 2. Create and save the new review
        Review::create($validatedData);

        // 3. Redirect back with a success message
        return redirect()->back()->with('success', 'Thank you for your review! It will be posted shortly.');
    }

    public function destroy(Review $review)
    {
        // TEMPORARILY COMMENT OUT THIS BLOCK FOR TESTING
        /*
        $expiryTime = Carbon::now()->subMinutes(5);

        if ($review->created_at->lt($expiryTime)) {
            return redirect()->route('admin.reviews.index')->with('error', 'Review deletion failed. Only reviews submitted within the last 5 minutes can be deleted.');
        }
        */

        // Simple deletion is performed
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('deleted', 'Review successfully deleted.');
    }
}
