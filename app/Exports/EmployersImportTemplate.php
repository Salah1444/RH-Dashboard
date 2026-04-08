<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

/**
 * Headers aligned on the UML « employer » class (diagramme PDF) + colonnes optionnelles (AR, RIB…).
 * CV / export PDF inchangés — mêmes champs Employer en base.
 */
class EmployersImportTemplate implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'cin_alpha',
            'cin_numeric',
            'cin',
            'nom_prenom',
            'photo',
            'date_naissance',
            'genre',
            'code_national',
            'adresse',
            'ville_id',
            'lieu_naissance',
            'tel_fixe',
            'tel_portable',
            'adresse_email',
            'sit_familiale',
            'position_id',
            'nom_prenom_ar',
            'adresse_ar',
            'rib',
            'num_pb',
        ];
    }

    public function collection(): Collection
    {
        return new Collection([
            array_fill(0, count($this->headings()), ''),
        ]);
    }
}
