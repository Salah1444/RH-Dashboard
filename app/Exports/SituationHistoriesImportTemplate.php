<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SituationHistoriesImportTemplate implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            // Example row
            ['AGE001', '1', '2024-01-15', '2045-06-30'],
        ];
    }

    public function headings(): array
    {
        return [
            'code_agent',
            'sit_st_id',
            'date_sit_stat',
            'date_prev_retraite',
        ];
    }
}
