<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Employer;
use App\Models\Congee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsenceController extends Controller
{
    public function index(Request $request)
    {
        $query = Absence::with(['employer', 'congee']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('employer', fn($q) =>
                $q->where('NOM_PRENOM_FR', 'like', "%$search%")
                  ->orWhere('CIN', 'like', "%$search%")
            );
        }
        if ($request->filled('justify')) {
            $query->where('is_justify', $request->justify === '1');
        }
        if ($request->filled('mois')) {
            $query->whereMonth('date_debut', $request->mois);
        }

        $absences     = $query->latest('date_debut')->paginate(15)->withQueryString();
        $totalAbs     = Absence::count();
        $justifiees   = Absence::where('is_justify', true)->count();
        $nonJustifiees= Absence::where('is_justify', false)->count();
        $moisCourant  = Absence::whereMonth('date_debut', now()->month)->whereYear('date_debut', now()->year)->count();
        $congees      = Congee::all();

        return view('absences.index', compact(
            'absences', 'totalAbs', 'justifiees', 'nonJustifiees', 'moisCourant', 'congees'
        ));
    }

    public function create()
    {
        $employes = Employer::orderBy('NOM_PRENOM_FR')->get();
        $congees  = Congee::all();
        return view('absences.create', compact('employes', 'congees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code_agent'  => 'required|exists:employer,COD_AG',
            'congee_id'   => 'nullable|exists:congee,id_congee',
            'date_debut'  => 'required|date',
            'date_fin'    => 'nullable|date|after_or_equal:date_debut',
            'is_justify'  => 'required|boolean',
            'certificat'  => 'nullable|file|mimes:pdf,jpg,png|max:4096',
        ]);

        if ($request->hasFile('certificat')) {
            $validated['certificat'] = $request->file('certificat')->store('certificats', 'public');
        }

        Absence::create($validated);
        return redirect()->route('absences.index')->with('success', 'Absence enregistrée.');
    }

    public function edit(Absence $absence)
    {
        $employes = Employer::orderBy('NOM_PRENOM_FR')->get();
        $congees  = Congee::all();
        return view('absences.create', compact('absence', 'employes', 'congees'));
    }

    public function update(Request $request, Absence $absence)
    {
        $validated = $request->validate([
            'code_agent'  => 'required|exists:employer,COD_AG',
            'congee_id'   => 'nullable|exists:congee,id_congee',
            'date_debut'  => 'required|date',
            'date_fin'    => 'nullable|date|after_or_equal:date_debut',
            'is_justify'  => 'required|boolean',
            'certificat'  => 'nullable|file|mimes:pdf,jpg,png|max:4096',
        ]);

        if ($request->hasFile('certificat')) {
            if ($absence->certificat) Storage::disk('public')->delete($absence->certificat);
            $validated['certificat'] = $request->file('certificat')->store('certificats', 'public');
        }

        $absence->update($validated);
        return redirect()->route('absences.index')->with('success', 'Absence mise à jour.');
    }

    public function destroy(Absence $absence)
    {
        if ($absence->certificat) Storage::disk('public')->delete($absence->certificat);
        $absence->delete();
        return redirect()->route('absences.index')->with('success', 'Absence supprimée.');
    }
}