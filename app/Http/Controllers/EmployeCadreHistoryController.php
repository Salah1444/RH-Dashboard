<?php

namespace App\Http\Controllers;

use App\Models\EmployeCadreHistory;
use App\Models\Employer;
use App\Models\Cadre;
use App\Http\Requests\EmployeCadreHistoryRequest;

class EmployeCadreHistoryController extends Controller
{
    public function index()
    {
        $histories = EmployeCadreHistory::with(['employe', 'cadre'])
            ->orderByDesc('DT_AFF_Cadre')
            ->paginate(20);

        return view('employe_cadre_history.index', compact('histories'));
    }

    public function create()
    {
        $employes = Employer::orderBy('NOM_PRENOM_FR')->get(['COD_AG', 'NOM_PRENOM_FR', 'CIN']);
        $cadres   = Cadre::orderBy('Lib_Cadre_FR')->get(['id_cadre', 'Lib_Cadre_FR', 'CADRE']);

        return view('employe_cadre_history.create', compact('employes', 'cadres'));
    }

    public function store(EmployeCadreHistoryRequest $request)
    {
        EmployeCadreHistory::create($request->validated());

        return redirect()->route('employe_cadre_history.index')
            ->with('success', 'Historique cadre ajouté avec succès.');
    }

    public function show(EmployeCadreHistory $employeCadreHistory)
    {
        $employeCadreHistory->load(['employe', 'cadre']);

        return view('employe_cadre_history.show', compact('employeCadreHistory'));
    }

    public function edit(EmployeCadreHistory $employeCadreHistory)
    {
        $employes = Employer::orderBy('NOM_PRENOM_FR')->get(['COD_AG', 'NOM_PRENOM_FR', 'CIN']);
        $cadres   = Cadre::orderBy('Lib_Cadre_FR')->get(['id_cadre', 'Lib_Cadre_FR', 'CADRE']);

        return view('employe_cadre_history.edit', compact('employeCadreHistory', 'employes', 'cadres'));
    }

    public function update(EmployeCadreHistoryRequest $request, EmployeCadreHistory $employeCadreHistory)
    {
        $employeCadreHistory->update($request->validated());

        return redirect()->route('employe_cadre_history.index')
            ->with('success', 'Historique cadre mis à jour avec succès.');
    }

    public function destroy(EmployeCadreHistory $employeCadreHistory)
    {
        $employeCadreHistory->delete();

        return redirect()->route('employe_cadre_history.index')
            ->with('success', 'Historique cadre supprimé avec succès.');
    }
}
