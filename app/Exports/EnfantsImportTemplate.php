<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EnfantsImportTemplate implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'code_agent',
            'nom_enf',
            'prenom',
            'rang_enf',
            'date_naissance_enf',
            'lien_juridique',
            'situation_enf',
            'gard_id',
        ];
    }

    public function collection(): Collection
    {
        return new Collection([
            array_fill(0, count($this->headings()), ''),
        ]);
    }
}
