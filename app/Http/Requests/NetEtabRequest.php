<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NetEtabRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'LIBELLE_net_etab' => ['required', 'string', 'max:150'],
        ];
    }

    public function messages(): array
    {
        return [
            'LIBELLE_net_etab.required' => 'Le libellé du réseau est obligatoire.',
        ];
    }
}
