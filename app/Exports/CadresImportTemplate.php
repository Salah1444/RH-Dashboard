<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CadresImportTemplate implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'cadre',
            'lib_cadre_fr',
            'lib_cadre_ar',
        ];
    }

    public function collection(): Collection
    {
        return new Collection([
            array_fill(0, count($this->headings()), ''),
        ]);
    }
}
