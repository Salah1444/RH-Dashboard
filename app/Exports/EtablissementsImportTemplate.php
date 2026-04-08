<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EtablissementsImportTemplate implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'nom_etab',
            'type_milieu',
            'nombre_eleves',
            'disponibilite_logement',
            'cd_commune',
            'modiriya_id',
            'cd_netab',
        ];
    }

    public function collection(): Collection
    {
        return new Collection([
            array_fill(0, count($this->headings()), ''),
        ]);
    }
}
