<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $primaryKey = 'movie_id';

    // Add columns from cinefeel/sql/cinefeel.sql
    protected $fillable = [
        'title', 'mood_id', 'description', 'poster_url',
        'trailer_link', 'release_year', 'duration'
    ];

    // Relates to a single mood
    public function mood()
    {
        return $this->belongsTo(Mood::class, 'mood_id');
    }

    // Relates to many genres via the pivot table 'movie_genres'
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genres', 'movie_id', 'genre_id');
    }

    // Relates to many users (favorites)
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'movie_id', 'user_id');
    }
}
