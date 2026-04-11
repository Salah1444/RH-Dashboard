<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommuneRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'LIB_COMMUNE_FR' => ['required', 'string', 'max:255'],
            'LIB_COMMUNE_AR' => ['nullable', 'string', 'max:255'],
            'LIB_MILIEU_FR'  => ['nullable', 'string', 'max:255'],
            'LIB_MILIEU_AR'  => ['nullable', 'string', 'max:255'],
            'CD_PRV'         => ['nullable', 'exists:province,CD_PRV'],
        ];
    }

    public function messages(): array
    {
        return [
            'LIB_COMMUNE_FR.required' => 'Le nom de la commune en français est obligatoire.',
            'CD_PRV.exists'           => 'La province sélectionnée n\'existe pas.',
        ];
    }
}
