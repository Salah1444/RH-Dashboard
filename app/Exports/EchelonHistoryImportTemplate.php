<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EchelonHistoryImportTemplate implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'code_agent',
            'id_ech',
            'indice',
            'dat_eff_elo',
        ];
    }

    public function collection(): Collection
    {
        return new Collection([
            array_fill(0, count($this->headings()), ''),
        ]);
    }
}
