<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeGradesHistoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'code_agent'    => ['required', 'exists:employer,COD_AG'],
            'id_grade'      => ['required', 'exists:grade,id_grade'],
            'ANC_GRADE'     => ['nullable', 'string', 'max:20'],
            'DAT_EFF_GR'    => ['nullable', 'date'],
            'MOD_AV_GRADE'  => ['nullable', 'string', 'max:100'],
            'LIBELLE_GRADE' => ['nullable', 'string', 'max:200'],
        ];
    }

    public function messages(): array
    {
        return [
            'code_agent.required' => "L'employé est obligatoire.",
            'code_agent.exists'   => "L'employé sélectionné n'existe pas.",
            'id_grade.required'   => 'Le grade est obligatoire.',
            'id_grade.exists'     => 'Le grade sélectionné n\'existe pas.',
        ];
    }
}
