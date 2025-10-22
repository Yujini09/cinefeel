<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public function mood() { return $this->belongsTo(Mood::class, 'mood_id'); }
    public function genres() { return $this->belongsToMany(Genre::class, 'movie_genres', 'movie_id', 'genre_id'); }
}
