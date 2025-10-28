<?php

namespace App\Http\Controllers;

use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Dashboard for admins
    public function dashboard()
    {
        $movieCount = \App\Http\Models\Movie::count();
        $moodCount = \App\Http\Models\Mood::count();

        // FIX: Implement sorting logic to process the 'sort' query parameter
        $query = \App\Http\Models\Movie::with('mood');

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
                // Join moods table to sort by relationship name
                $query->join('moods', 'movies.mood_id', '=', 'moods.id')
                      ->orderBy('moods.name', 'asc')
                      ->select('movies.*'); // Select movies.* to prevent column ambiguity
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $movies = $query->simplePaginate(10);
        $admins = User::whereIn('role', ['admin', 'superadmin'])->get();
        return view('admin.dashboard', compact('movieCount', 'moodCount', 'movies', 'admins'));
    }

}