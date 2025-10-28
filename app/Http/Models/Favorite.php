<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'movie_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Http\Models\User::class);
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(\App\Http\Models\Movie::class);
    }
}
