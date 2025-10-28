<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(\App\Http\Models\Movie::class, 'movie_genre');
    }
}
