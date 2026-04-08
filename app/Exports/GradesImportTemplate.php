<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GradesImportTemplate implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'grade',
            'lib_grade_fr',
            'lib_grade_ar',
        ];
    }

    public function collection(): Collection
    {
        return new Collection([
            array_fill(0, count($this->headings()), ''),
        ]);
    }
}
