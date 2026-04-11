<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProvinceRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'LIB_PROVINCE_FR' => ['required', 'string', 'max:100'],
            'LIB_PROVINCE_AR' => ['nullable', 'string', 'max:100'],
            'CD_REG'          => ['nullable', 'exists:region,CD_REG'],
        ];
    }

    public function messages(): array
    {
        return [
            'LIB_PROVINCE_FR.required' => 'Le nom de la province en français est obligatoire.',
            'CD_REG.exists'            => 'La région sélectionnée n\'existe pas.',
        ];
    }
}
