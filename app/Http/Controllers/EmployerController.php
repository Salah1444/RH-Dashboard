<?php

namespace App\Http\Controllers;

use App\Models\Cadre;
use App\Models\Employer;
use App\Models\Affectation;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function index(Request $request)
    {
        // ── Listes pour les filtres ────────────────────────────────
        $regions = Affectation::query()
            ->with('etablissement.commune.province.region')
            ->get()
            ->map(fn($a) => $a->etablissement?->commune?->province?->region?->LIB_REGION_FR)
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $cadres = Cadre::orderBy('Lib_Cadre_FR')->pluck('Lib_Cadre_FR');

        $situationsFamiliales = Employer::whereNotNull('Sit_Familiale')
            ->distinct()
            ->orderBy('Sit_Familiale')
            ->pluck('Sit_Familiale');

        // ── Requête principale paginée ─────────────────────────────
        $Employer = Employer::query()
            ->with([
                'affectationActuelle.etablissement.commune.province.region',
                'affectationActuelle.fonction',
                'cadreActuel.cadre',
                'gradeActuel.grade',
                'situationStatutaireActuelle.situationStatutaire',
            ])
            ->search($request->input('search'))
            ->filterSexe($request->input('sexe'))
            ->filterSitFamiliale($request->input('sit_familiale'))
            ->filterRegion($request->input('region'))
            ->filterCadre($request->input('cadre'))
            ->orderBy('NOM_PRENOM_FR')
            ->paginate(15)
            ->withQueryString();

        // ── Stats rapides ──────────────────────────────────────────
        $stats = [
            'total'     => Employer::count(),
            'hommes'    => Employer::where('SEXE', 'M')->count(),
            'femmes'    => Employer::where('SEXE', 'F')->count(),
            'resultats' => $Employer->total(),
        ];

        return view('employers.index', compact(
            'Employer', 'regions', 'cadres', 'situationsFamiliales', 'stats'
        ));
    }

    public function show(int $id)
    {
        $Employer = Employer::with([
            'commune.province.region',
            'position',
            'affectations.etablissement.commune.province.region',
            'affectations.fonction',
            'affectationActuelle.etablissement.commune.province.region',
            'affectationActuelle.fonction',
            'cadreHistory.cadre',
            'cadreActuel.cadre',
            'gradeHistory.grade',
            'gradeActuel.grade',
            'echelonHistory.echelon',
            'echelonActuel.echelon',
            'situationStatutaireHistory.situationStatutaire',
            'situationStatutaireActuelle.situationStatutaire',
            'conjoints',
            'enfants.garde',
            'diplomes',
            'absences.congee',
        ])->findOrFail($id);

        return view('employers.show', compact('Employer'));
    }
}
