<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateWorkoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "selectedMuscles" => ["required", "array"],
            "selectedMuscles.*" => ["required", "integer", "exists:muscle_groups,id"],
            "focusMuscles" => ["array"],
            "focusMuscles.*" => ["required", "integer", "exists:muscle_groups,id"],
            "selectedDays" => ["required", "array"],
            "selectedDays.*" => ["required", "string"],
            "duration" => ["required", "integer"],
        ];
    }
}
