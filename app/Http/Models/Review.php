<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reviewer_name', // <-- ADD THIS
        'rating',        // <-- ADD THIS
        'review_text',   // <-- ADD THIS
        // Add any other fields you want to create/update via Model::create()
    ];
}