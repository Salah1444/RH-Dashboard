<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SituationsImportTemplate implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'code_sit_statutaire',
            'lib_situation_statutaire_fr',
            'lib_situation_statutaire_ar',
        ];
    }

    public function collection(): Collection
    {
        return new Collection([
            array_fill(0, count($this->headings()), ''),
        ]);
    }
}
