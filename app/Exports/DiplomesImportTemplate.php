<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DiplomesImportTemplate implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'code_agent',
            'll_dip',
            'dt_dip',
            'etablissement_formation',
            'montion',
            'type_dip',
        ];
    }

    public function collection(): Collection
    {
        return new Collection([
            array_fill(0, count($this->headings()), ''),
        ]);
    }
}
