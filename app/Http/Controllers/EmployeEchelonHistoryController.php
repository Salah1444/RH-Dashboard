<?php

namespace App\Http\Controllers;

use App\Models\EmployeEchelonHistory;
use App\Models\Employer;
use App\Models\Echelon;
use App\Http\Requests\EmployeEchelonHistoryRequest;

class EmployeEchelonHistoryController extends Controller
{
    public function index()
    {
        $histories = EmployeEchelonHistory::with(['employe', 'echelon'])
            ->orderByDesc('DAT_EFF_ELO')
            ->paginate(20);

        return view('employe_echelon_history.index', compact('histories'));
    }

    public function create()
    {
        $employes = Employer::orderBy('NOM_PRENOM_FR')->get(['COD_AG', 'NOM_PRENOM_FR', 'CIN']);
        $echelons = Echelon::orderBy('COD_ECH')->get(['id_ech', 'COD_ECH', 'COD_ELO']);

        return view('employe_echelon_history.create', compact('employes', 'echelons'));
    }

    public function store(EmployeEchelonHistoryRequest $request)
    {
        EmployeEchelonHistory::create($request->validated());

        return redirect()->route('employe_echelon_history.index')
            ->with('success', 'Historique échelon ajouté avec succès.');
    }

    public function show(EmployeEchelonHistory $employeEchelonHistory)
    {
        $employeEchelonHistory->load(['employe', 'echelon']);

        return view('employe_echelon_history.show', compact('employeEchelonHistory'));
    }

    public function edit(EmployeEchelonHistory $employeEchelonHistory)
    {
        $employes = Employer::orderBy('NOM_PRENOM_FR')->get(['COD_AG', 'NOM_PRENOM_FR', 'CIN']);
        $echelons = Echelon::orderBy('COD_ECH')->get(['id_ech', 'COD_ECH', 'COD_ELO']);

        return view('employe_echelon_history.edit', compact('employeEchelonHistory', 'employes', 'echelons'));
    }

    public function update(EmployeEchelonHistoryRequest $request, EmployeEchelonHistory $employeEchelonHistory)
    {
        $employeEchelonHistory->update($request->validated());

        return redirect()->route('employe_echelon_history.index')
            ->with('success', 'Historique échelon mis à jour avec succès.');
    }

    public function destroy(EmployeEchelonHistory $employeEchelonHistory)
    {
        $employeEchelonHistory->delete();

        return redirect()->route('employe_echelon_history.index')
            ->with('success', 'Historique échelon supprimé avec succès.');
    }
}
