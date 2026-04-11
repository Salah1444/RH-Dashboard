<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeSituationStatutaireHistoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'code_agent'         => ['required', 'exists:employer,COD_AG'],
            'sit_st_id'          => ['required', 'exists:situation_statutaire,sit_st_id'],
            'DATE_SIT_STAT'      => ['nullable', 'date'],
            'DATE_PREV_RETRAITE' => ['nullable', 'date', 'after_or_equal:DATE_SIT_STAT'],
        ];
    }

    public function messages(): array
    {
        return [
            'code_agent.required'               => "L'employé est obligatoire.",
            'code_agent.exists'                 => "L'employé sélectionné n'existe pas.",
            'sit_st_id.required'                => 'La situation statutaire est obligatoire.',
            'sit_st_id.exists'                  => 'La situation statutaire sélectionnée n\'existe pas.',
            'DATE_PREV_RETRAITE.after_or_equal' => 'La date de retraite prévue doit être après ou égale à la date de situation.',
        ];
    }
}
