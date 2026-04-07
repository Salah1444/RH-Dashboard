<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Commune;
use App\Models\Position;
use App\Models\Cadre;
use App\Models\Grade;
use App\Models\Echelon;
use App\Models\SituationStatutaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployerController extends Controller
{
    public function index(Request $request)
    {
        $query = Employer::with(['position', 'commune']);

        // Filtres
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('NOM_PRENOM_FR', 'like', "%$search%")
                  ->orWhere('CIN', 'like', "%$search%")
                  ->orWhere('COD_AG', 'like', "%$search%");
            });
        }
        if ($request->filled('sexe')) {
            $query->where('SEXE', $request->sexe);
        }
        if ($request->filled('position_id')) {
            $query->where('position_id', $request->position_id);
        }

        $employes  = $query->latest()->paginate(15)->withQueryString();
        $positions = Position::all();
        $total     = Employer::count();
        $hommes    = Employer::where('SEXE', 'M')->count();
        $femmes    = Employer::where('SEXE', 'F')->count();

        return view('employes.index', compact('employes', 'positions', 'total', 'hommes', 'femmes'));
    }

    public function create()
    {
        $communes   = Commune::orderBy('LIB_COMMUNE_FR')->get();
        $positions  = Position::all();
        return view('employes.create', compact('communes', 'positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'CIN'           => 'required|string|max:20|unique:employer,CIN',
            'NOM_PRENOM_FR' => 'required|string|max:200',
            'NOM_PRENOM_AR' => 'nullable|string|max:200',
            'DATE_NAISS'    => 'nullable|date',
            'SEXE'          => 'nullable|in:M,F',
            'TEL_PORTABLE'  => 'nullable|string|max:20',
            'ADRESSE_ELEC'  => 'nullable|email|max:150',
            'Sit_Familiale' => 'nullable|string|max:100',
            'ville_id'      => 'nullable|exists:commune,CD_COM',
            'position_id'   => 'nullable|exists:position,COD_POS',
            'photo'         => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        } else {
            $validated['photo'] = 'default.png';
        }

        Employer::create($validated);

        return redirect()->route('employes.index')
                         ->with('success', 'Employé créé avec succès.');
    }

    public function show(Employer $employer)
    {
        $employer->load([
            'position', 'commune.province.region',
            'affectations.etablisement', 'affectations.fonction',
            'cadreHistories.cadre',
            'gradeHistories.grade',
            'echelonHistories.echelon',
            'situationStatutaireHistories.situationStatutaire',
            'conjoints', 'enfants', 'diplomes', 'absences.congee',
        ]);
        return view('employes.show', compact('employer'));
    }

    public function edit(Employer $employer)
    {
        $communes  = Commune::orderBy('LIB_COMMUNE_FR')->get();
        $positions = Position::all();
        return view('employes.edit', compact('employer', 'communes', 'positions'));
    }

    public function update(Request $request, Employer $employer)
    {
        $validated = $request->validate([
            'CIN'           => 'required|string|max:20|unique:employer,CIN,' . $employer->COD_AG . ',COD_AG',
            'NOM_PRENOM_FR' => 'required|string|max:200',
            'NOM_PRENOM_AR' => 'nullable|string|max:200',
            'DATE_NAISS'    => 'nullable|date',
            'SEXE'          => 'nullable|in:M,F',
            'TEL_PORTABLE'  => 'nullable|string|max:20',
            'ADRESSE_ELEC'  => 'nullable|email|max:150',
            'Sit_Familiale' => 'nullable|string|max:100',
            'ville_id'      => 'nullable|exists:commune,CD_COM',
            'position_id'   => 'nullable|exists:position,COD_POS',
            'photo'         => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($employer->photo && $employer->photo !== 'default.png') {
                Storage::disk('public')->delete($employer->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $employer->update($validated);

        return redirect()->route('employes.show', $employer)
                         ->with('success', 'Employé mis à jour.');
    }

    public function destroy(Employer $employer)
    {
        if ($employer->photo && $employer->photo !== 'default.png') {
            Storage::disk('public')->delete($employer->photo);
        }
        $employer->delete();
        return redirect()->route('employes.index')
                         ->with('success', 'Employé supprimé.');
    }
}
