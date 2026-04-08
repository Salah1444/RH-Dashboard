<?php

namespace App\Http\Controllers;

use App\Models\Diplome;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DiplomesImport;
use App\Exports\DiplomesImportTemplate;

class DiplomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Diplome::with('employer');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('LL_DIP', 'like', "%$search%")
                  ->orWhereHas('employer', fn($q2) => $q2->where('NOM_PRENOM_FR', 'like', "%$search%"));
            });
        }
        if ($request->filled('type')) {
            $query->where('TYPE_DIP', $request->type);
        }

        $diplomes    = $query->latest('DT_DIP')->paginate(15)->withQueryString();
        $totalDip    = Diplome::count();
        $scolaires   = Diplome::where('TYPE_DIP', 'SCOLAIRE')->count();
        $pro         = Diplome::where('TYPE_DIP', 'PRO')->count();
        $avecPDF     = Diplome::whereNotNull('PDF')->count();

        return view('diplomes.index', compact('diplomes', 'totalDip', 'scolaires', 'pro', 'avecPDF'));
    }

    public function create()
    {
        $employes = Employer::orderBy('NOM_PRENOM_FR')->get();
        return view('diplomes.create', compact('employes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'LL_DIP'                  => 'required|string|max:200',
            'DT_DIP'                  => 'nullable|date',
            'code_agent'              => 'required|exists:employer,COD_AG',
            'etablissement_formation' => 'nullable|string|max:200',
            'montion'                 => 'nullable|numeric|min:0|max:20',
            'TYPE_DIP'                => 'required|in:SCOLAIRE,PRO',
            'PDF'                     => 'nullable|file|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('PDF')) {
            $validated['PDF'] = $request->file('PDF')->store('diplomes', 'public');
        }

        Diplome::create($validated);
        return redirect()->route('diplomes.index')->with('success', 'Diplôme ajouté.');
    }

    public function edit(Diplome $diplome)
    {
        $employes = Employer::orderBy('NOM_PRENOM_FR')->get();
        return view('diplomes.create', compact('diplome', 'employes'));
    }

    public function update(Request $request, Diplome $diplome)
    {
        $validated = $request->validate([
            'LL_DIP'                  => 'required|string|max:200',
            'DT_DIP'                  => 'nullable|date',
            'code_agent'              => 'required|exists:employer,COD_AG',
            'etablissement_formation' => 'nullable|string|max:200',
            'montion'                 => 'nullable|numeric|min:0|max:20',
            'TYPE_DIP'                => 'required|in:SCOLAIRE,PRO',
            'PDF'                     => 'nullable|file|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('PDF')) {
            if ($diplome->PDF) Storage::disk('public')->delete($diplome->PDF);
            $validated['PDF'] = $request->file('PDF')->store('diplomes', 'public');
        }

        $diplome->update($validated);
        return redirect()->route('diplomes.index')->with('success', 'Diplôme mis à jour.');
    }

    public function destroy(Diplome $diplome)
    {
        if ($diplome->PDF) Storage::disk('public')->delete($diplome->PDF);
        $diplome->delete();
        return redirect()->route('diplomes.index')->with('success', 'Diplôme supprimé.');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);
        try {
            Excel::import(new DiplomesImport, $request->file('excel_file'));
            return redirect()->route('diplomes.index')->with('success', 'Importation réussie.');
        } catch (\Throwable $e) {
            return redirect()->route('diplomes.index')->with('error', 'Erreur lors de l\'importation : ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new DiplomesImportTemplate, 'modele_diplomes.xlsx');
    }
}
