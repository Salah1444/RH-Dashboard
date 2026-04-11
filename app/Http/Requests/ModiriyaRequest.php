<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModiriyaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nom_modiriya' => ['required', 'string', 'max:150'],
            'id_region'    => ['nullable', 'exists:region,CD_REG'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom_modiriya.required' => 'Le nom de la modiriya est obligatoire.',
            'id_region.exists'      => 'La région sélectionnée n\'existe pas.',
        ];
    }
}
