<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'poster_url',
        'backdrop_path',
        'rating',
        'release_year',
        'director',
        'cast',
        'trailer_url',
        'mood_id',
        'genre',
        'duration'
    ];

    protected $casts = [
        'cast' => 'array',
        'rating' => 'decimal:1'
    ];

    public function mood(): BelongsTo
    {
        return $this->belongsTo(Mood::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'movie_genre');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}
