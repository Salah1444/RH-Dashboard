<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CadreHistoryImportTemplate implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'code_agent',
            'id_cadre',
            'anc_adm',
            'dt_aff_cadre',
        ];
    }

    public function collection(): Collection
    {
        return new Collection([
            array_fill(0, count($this->headings()), ''),
        ]);
    }
}
