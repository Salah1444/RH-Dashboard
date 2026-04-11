<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeCadreHistoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'code_agent'   => ['required', 'exists:employer,COD_AG'],
            'id_cadre'     => ['required', 'exists:cadre,id_cadre'],
            'ANC_ADM'      => ['nullable', 'string', 'max:20'],
            'DT_AFF_Cadre' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'code_agent.required' => "L'employé est obligatoire.",
            'code_agent.exists'   => "L'employé sélectionné n'existe pas.",
            'id_cadre.required'   => 'Le cadre est obligatoire.',
            'id_cadre.exists'     => 'Le cadre sélectionné n\'existe pas.',
        ];
    }
}
