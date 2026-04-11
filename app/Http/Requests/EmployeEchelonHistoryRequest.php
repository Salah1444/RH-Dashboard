<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeEchelonHistoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'code_agent'  => ['required', 'exists:employer,COD_AG'],
            'id_ech'      => ['required', 'exists:echelon,id_ech'],
            'INDICE'      => ['nullable', 'string', 'max:20'],
            'DAT_EFF_ELO' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'code_agent.required' => "L'employé est obligatoire.",
            'code_agent.exists'   => "L'employé sélectionné n'existe pas.",
            'id_ech.required'     => "L'échelon est obligatoire.",
            'id_ech.exists'       => "L'échelon sélectionné n'existe pas.",
        ];
    }
}
