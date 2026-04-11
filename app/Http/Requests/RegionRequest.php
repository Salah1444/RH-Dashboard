<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegionRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'LIB_REGION_FR' => ['required', 'string', 'max:100'],
            'LIB_REGION_AR' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'LIB_REGION_FR.required' => 'Le nom de la région en français est obligatoire.',
        ];
    }
}
