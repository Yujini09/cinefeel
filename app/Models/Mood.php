<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    public function movies() { return $this->hasMany(Movie::class, 'mood_id'); }
}
