<?php

namespace App\Exports;

use App\Models\Employer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class EmployersExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Employer::with(['position', 'commune',
            'gradeActuel.grade',
            'cadreActuel.cadre',
            'echelonActuel.echelon',
            'affectationActuelle.etablissement',
            'affectationActuelle.fonction',
        ]);

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('NOM_PRENOM_FR', 'like', "%$search%")
                  ->orWhere('CIN', 'like', "%$search%")
                  ->orWhere('COD_AG', 'like', "%$search%");
            });
        }
        if ($this->request->filled('sexe')) {
            $query->where('SEXE', $this->request->sexe);
        }
        if ($this->request->filled('position_id')) {
            $query->where('position_id', $this->request->position_id);
        }

        return $query->latest();
    }

    public function title(): string
    {
        return 'Employés';
    }

    public function headings(): array
    {
        return [
            'Code Agent',
            'CIN',
            'Nom & Prénom (FR)',
            'Nom & Prénom (AR)',
            'Date de Naissance',
            'Lieu de Naissance',
            'Sexe',
            'Situation Familiale',
            'Tél. Portable',
            'Tél. Fixe',
            'Email',
            'Adresse (FR)',
            'Adresse (AR)',
            'Ville',
            'Position',
            'Grade Actuel',
            'Cadre Actuel',
            'Échelon Actuel',
            'Établissement Actuel',
            'Fonction Actuelle',
            'RIB',
        ];
    }

    public function map($employer): array
    {
        return [
            $employer->COD_AG,
            $employer->CIN,
            $employer->NOM_PRENOM_FR,
            $employer->NOM_PRENOM_AR,
            $employer->DATE_NAISS ? $employer->DATE_NAISS->format('d/m/Y') : '',
            $employer->LIEU_NAISS,
            $employer->SEXE === 'M' ? 'Homme' : ($employer->SEXE === 'F' ? 'Femme' : ''),
            $employer->Sit_Familiale,
            $employer->TEL_PORTABLE,
            $employer->TEL_FIXE,
            $employer->ADRESSE_ELEC,
            $employer->ADRESSE_FR,
            $employer->ADRESSE_AR,
            optional($employer->commune)->LIB_COMMUNE_FR,
            optional($employer->position)->LIB_POSITION_FR,
            optional(optional($employer->gradeActuel)->grade)->LIB_GRADE_FR,
            optional(optional($employer->cadreActuel)->cadre)->LIB_CADRE_FR ?? '',
            optional(optional($employer->echelonActuel)->echelon)->LIB_ECH ?? '',
            optional(optional($employer->affectationActuelle)->etablissement)->LIB_ETAB_FR ?? '',
            optional(optional($employer->affectationActuelle)->fonction)->LIB_FONC_FR ?? '',
            $employer->RIB,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Header row: dark blue background, white bold text, centered
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4E73DF']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}
