<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->input('CIN') === '') {
            $this->merge(['CIN' => null]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'CIN_A' => ['nullable', 'string', 'max:20'],
            'CIN_N' => ['nullable', 'string', 'max:20'],
            'CIN' => ['required', 'string', 'max:20', 'unique:employer,CIN'],
            'NOM_PRENOM_FR' => ['nullable', 'string', 'max:200'],
            'NOM_PRENOM_AR' => ['nullable', 'string', 'max:200'],
            'photo' => ['nullable', 'image', 'max:4096'],
            'DATE_NAISS' => ['nullable', 'date'],
            'LIEU_NAISS' => ['nullable', 'string', 'max:150'],
            'SEXE' => ['nullable', 'in:M,F'],
            'CODE_NAT' => ['nullable', 'string', 'max:20'],
            'ADRESSE_FR' => ['nullable', 'string', 'max:255'],
            'ADRESSE_AR' => ['nullable', 'string', 'max:255'],
            'TEL_FIXE' => ['nullable', 'string', 'max:20'],
            'TEL_PORTABLE' => ['nullable', 'string', 'max:20'],
            'ADRESSE_ELEC' => ['nullable', 'string', 'max:150'],
            'Sit_Familiale' => ['nullable', 'string', 'max:100'],
            'RIB' => ['nullable', 'string', 'max:30'],
            'NUM_PB' => ['nullable', 'string', 'max:30'],
            'ville_id' => ['nullable', 'integer', 'exists:commune,CD_COM'],
            'position_id' => ['nullable', 'integer', 'exists:position,COD_POS'],
        ];
    }
}
