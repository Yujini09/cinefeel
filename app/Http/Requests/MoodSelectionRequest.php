<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MoodSelectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all users
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mood_id' => 'required|exists:moods,id',
        ];
    }
}
