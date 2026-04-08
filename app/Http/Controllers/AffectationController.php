<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Employer;
use App\Models\Etablissement;
use App\Models\Fonction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AffectationsImport;
use App\Exports\AffectationsImportTemplate;

class AffectationController extends Controller
{
    public function index(Request $request)
    {
        $query = Affectation::with(['employer', 'Etablissement', 'fonction']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('employer', fn($q) =>
                $q->where('NOM_PRENOM_FR', 'like', "%$search%")
                  ->orWhere('CIN', 'like', "%$search%")
            );
        }
        if ($request->filled('mode')) {
            $query->where('Mode_Affectation', $request->mode);
        }
        if ($request->filled('etab')) {
            $query->where('code_etab', $request->etab);
        }

        $affectations   = $query->latest('DT_AFF_POSTE')->paginate(15)->withQueryString();
        $etablissements = Etablissement::orderBy('NOM_ETAB')->get();
        $modes = Affectation::select('Mode_Affectation')->distinct()->whereNotNull('Mode_Affectation')->pluck('Mode_Affectation');

        // KPIs
        $totalAff     = Affectation::count();
        $mutations    = Affectation::where('Mode_Affectation', 'Mutation')->count();
        $detachements = Affectation::where('Mode_Affectation', 'Détachement')->count();
        $interims     = Affectation::where('Mode_Affectation', 'Intérim')->count();

        return view('affectations.index', compact(
            'affectations', 'etablissements', 'modes',
            'totalAff', 'mutations', 'detachements', 'interims'
        ));
    }

    public function create()
    {
        $employes       = Employer::orderBy('NOM_PRENOM_FR')->get();
        $etablissements = Etablissement::orderBy('NOM_ETAB')->get();
        $fonctions      = Fonction::orderBy('LIB_FONCTION_FR')->get();
        return view('affectations.create', compact('employes', 'etablissements', 'fonctions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code_agent'          => 'required|exists:employer,COD_AG',
            'code_etab'           => 'nullable|exists:Etablissement,CD_ETAB',
            'fonction_id'         => 'nullable|exists:fonction,CODE_FONCTION',
            'DT_AFF_POSTE'        => 'nullable|date',
            'DATE_DEBUT_AFF'      => 'nullable|date',
            'Date_aff_delegation' => 'nullable|date',
            'Date_aff_aref'       => 'nullable|date',
            'Mode_Affectation'    => 'nullable|string|max:100',
        ]);

        Affectation::create($validated);

        return redirect()->route('affectations.index')
                         ->with('success', 'Affectation créée avec succès.');
    }

    public function edit(Affectation $affectation)
    {
        $employes       = Employer::orderBy('NOM_PRENOM_FR')->get();
        $etablissements = Etablissement::orderBy('NOM_ETAB')->get();
        $fonctions      = Fonction::orderBy('LIB_FONCTION_FR')->get();
        return view('affectations.edit', compact('affectation', 'employes', 'etablissements', 'fonctions'));
    }

    public function update(Request $request, Affectation $affectation)
    {
        $validated = $request->validate([
            'code_agent'          => 'required|exists:employer,COD_AG',
            'code_etab'           => 'nullable|exists:Etablissement,CD_ETAB',
            'fonction_id'         => 'nullable|exists:fonction,CODE_FONCTION',
            'DT_AFF_POSTE'        => 'nullable|date',
            'DATE_DEBUT_AFF'      => 'nullable|date',
            'Date_aff_delegation' => 'nullable|date',
            'Date_aff_aref'       => 'nullable|date',
            'Mode_Affectation'    => 'nullable|string|max:100',
        ]);

        $affectation->update($validated);

        return redirect()->route('affectations.index')
                         ->with('success', 'Affectation mise à jour.');
    }

    public function destroy(Affectation $affectation)
    {
        $affectation->delete();
        return redirect()->route('affectations.index')
                         ->with('success', 'Affectation supprimée.');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);
        try {
            Excel::import(new AffectationsImport, $request->file('excel_file'));
            return redirect()->route('affectations.index')->with('success', 'Importation réussie.');
        } catch (\Throwable $e) {
            return redirect()->route('affectations.index')->with('error', 'Erreur lors de l\'importation : ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new AffectationsImportTemplate, 'modele_affectations.xlsx');
    }
}
