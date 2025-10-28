<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // For now, allow all users
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'poster_path' => 'nullable|string|max:255',
            'backdrop_path' => 'nullable|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:10',
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'director' => 'nullable|string|max:255',
            'cast' => 'nullable|array',
            'cast.*' => 'string|max:255',
            'trailer_url' => 'nullable|url',
            'mood_id' => 'required|exists:moods,id',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
        ];
    }
}
