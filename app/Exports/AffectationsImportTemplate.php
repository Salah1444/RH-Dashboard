<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AffectationsImportTemplate implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'code_agent',
            'code_etab',
            'fonction_id',
            'dt_aff_poste',
            'date_debut_aff',
            'date_aff_delegation',
            'date_aff_aref',
            'mode_affectation',
        ];
    }

    public function collection(): Collection
    {
        return new Collection([
            array_fill(0, count($this->headings()), ''),
        ]);
    }
}
