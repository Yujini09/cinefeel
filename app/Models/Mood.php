<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    protected $primaryKey = 'mood_id';

    // Add columns from cinefeel/sql/cinefeel.sql
    protected $fillable = ['mood_name', 'mapped_genre', 'emoji', 'description'];

    // Relates to movies
    public function movies()
    {
        return $this->hasMany(Movie::class, 'mood_id');
    }
}
