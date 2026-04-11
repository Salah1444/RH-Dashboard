<?php

namespace App\Http\Controllers;

use App\Models\Conjoint;
use App\Models\Enfant;
use App\Models\Employer;
use App\Models\Garde;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ConjointsImport;
use App\Imports\EnfantsImport;
use App\Exports\ConjointsImportTemplate;
use App\Exports\EnfantsImportTemplate;

class FamilleController extends Controller
{
    /* ═══════════════════════ CONJOINTS ═══════════════════════ */

    public function conjoints(Request $request)
    {
        $query = Conjoint::with('employer');
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nom_prenom_conjoint', 'like', "%$s%")
                  ->orWhereHas('employer', fn($q2) => $q2->where('NOM_PRENOM_FR', 'like', "%$s%"));
            });
        }
        $conjoints    = $query->latest()->paginate(15)->withQueryString();
        $totalConj    = Conjoint::count();
        $employes     = Employer::orderBy('NOM_PRENOM_FR')->get();
        return view('famille.conjoints', compact('conjoints', 'totalConj', 'employes'));
    }

    public function storeConjoint(Request $request)
    {
        $validated = $request->validate([
            'code_agent'          => 'required|exists:employer,COD_AG',
            'DATE_SIT_FAM'        => 'nullable|date',
            'nom_prenom_conjoint' => 'required|string|max:200',
            'rang_conj'           => 'nullable|integer|min:1',
            'cin_conj'            => 'nullable|string|max:20',
            'nationalite_conj'    => 'nullable|string|max:80',
            'fonction_conj'       => 'nullable|string|max:150',
        ]);
        Conjoint::create($validated);
        return redirect()->route('famille.conjoints')->with('success', 'Conjoint ajouté.');
    }

    public function destroyConjoint(Conjoint $conjoint)
    {
        $conjoint->delete();
        return redirect()->route('famille.conjoints')->with('success', 'Conjoint supprimé.');
    }

    /* ═══════════════════════ ENFANTS ═════════════════════════ */

    public function enfants(Request $request)
    {

        $query = Enfant::with(['employer', 'garde']);
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nom_enf', 'like', "%$s%")
                  ->orWhereHas('employer', fn($q2) => $q2->where('NOM_PRENOM_FR', 'like', "%$s%"));
            });
        }
        $enfants   = $query->latest()->paginate(15)->withQueryString();
        $totalEnf  = Enfant::count();
        $employes  = Employer::orderBy('NOM_PRENOM_FR')->get();
        $gardes    = Garde::all();
        
        return view('famille.enfants', compact('enfants', 'totalEnf', 'employes', 'gardes'));
    }

    public function storeEnfant(Request $request)
    {
        $validated = $request->validate([
            'code_agent'         => 'required|exists:employer,COD_AG',
            'nom_enf'            => 'required|string|max:200',
            'prenom'             => 'nullable|string|max:200',
            'rang_enf'           => 'nullable|integer|min:1',
            'date_naissance_enf' => 'nullable|date',
            'lien_juridique'     => 'nullable|string|max:100',
            'situation_enf'      => 'nullable|string|max:100',
            'gard_id'            => 'nullable|exists:garde,id_garde',
        ]);
        Enfant::create($validated);
        return redirect()->route('famille.enfants')->with('success', 'Enfant ajouté.');
    }

    public function destroyEnfant(Enfant $enfant)
    {
        $enfant->delete();
        return redirect()->route('famille.enfants')->with('success', 'Enfant supprimé.');
    }


    /* ──── Import Excel Conjoints ──── */

    public function importConjoints(Request $request)
    {
        $request->validate(['excel_file' => 'required|file|mimes:xlsx,xls,csv']);
        try {
            Excel::import(new ConjointsImport, $request->file('excel_file'));
            return redirect()->route('famille.conjoints')->with('success', 'Conjoints importés avec succès.');
        } catch (\Throwable $e) {
            return redirect()->route('famille.conjoints')->with('error', 'Erreur importation : ' . $e->getMessage());
        }
    }

    public function downloadConjointsTemplate()
    {
        return Excel::download(new ConjointsImportTemplate, 'modele_conjoints.xlsx');
    }

    /* ──── Import Excel Enfants ──── */

    public function importEnfants(Request $request)
    {
        $request->validate(['excel_file' => 'required|file|mimes:xlsx,xls,csv']);
        try {
            Excel::import(new EnfantsImport, $request->file('excel_file'));
            return redirect()->route('famille.enfants')->with('success', 'Enfants importés avec succès.');
        } catch (\Throwable $e) {
            return redirect()->route('famille.enfants')->with('error', 'Erreur importation : ' . $e->getMessage());
        }
    }

    public function downloadEnfantsTemplate()
    {
        return Excel::download(new EnfantsImportTemplate, 'modele_enfants.xlsx');
    }
}
