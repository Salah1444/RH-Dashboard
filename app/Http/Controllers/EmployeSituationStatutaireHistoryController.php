<?php

namespace App\Http\Controllers;

use App\Models\EmployeSituationStatutaireHistory;
use App\Models\Employer;
use App\Models\SituationStatutaire;
use App\Http\Requests\EmployeSituationStatutaireHistoryRequest;

class EmployeSituationStatutaireHistoryController extends Controller
{
    public function index()
    {
        $histories = EmployeSituationStatutaireHistory::with(['employe', 'situationStatutaire'])
            ->orderByDesc('DATE_SIT_STAT')
            ->paginate(20);

        return view('employe_situation_statutaire_history.index', compact('histories'));
    }

    public function create()
    {
        $employes   = Employer::orderBy('NOM_PRENOM_FR')->get(['COD_AG', 'NOM_PRENOM_FR', 'CIN']);
        $situations = SituationStatutaire::orderBy('LIB_SITUATION_STATUTAIRE_FR')
            ->get(['sit_st_id', 'LIB_SITUATION_STATUTAIRE_FR', 'CODE_SIT_STATUTAIRE']);

        return view('employe_situation_statutaire_history.create', compact('employes', 'situations'));
    }

    public function store(EmployeSituationStatutaireHistoryRequest $request)
    {
        EmployeSituationStatutaireHistory::create($request->validated());

        return redirect()->route('employe_situation_statutaire_history.index')
            ->with('success', 'Historique situation statutaire ajouté avec succès.');
    }

    public function show(EmployeSituationStatutaireHistory $employeSituationStatutaireHistory)
    {
        $employeSituationStatutaireHistory->load(['employe', 'situationStatutaire']);

        return view('employe_situation_statutaire_history.show', compact('employeSituationStatutaireHistory'));
    }

    public function edit(EmployeSituationStatutaireHistory $employeSituationStatutaireHistory)
    {
        $employes   = Employer::orderBy('NOM_PRENOM_FR')->get(['COD_AG', 'NOM_PRENOM_FR', 'CIN']);
        $situations = SituationStatutaire::orderBy('LIB_SITUATION_STATUTAIRE_FR')
            ->get(['sit_st_id', 'LIB_SITUATION_STATUTAIRE_FR', 'CODE_SIT_STATUTAIRE']);

        return view('employe_situation_statutaire_history.edit', compact('employeSituationStatutaireHistory', 'employes', 'situations'));
    }

    public function update(EmployeSituationStatutaireHistoryRequest $request, EmployeSituationStatutaireHistory $employeSituationStatutaireHistory)
    {
        $employeSituationStatutaireHistory->update($request->validated());

        return redirect()->route('employe_situation_statutaire_history.index')
            ->with('success', 'Historique situation statutaire mis à jour avec succès.');
    }

    public function destroy(EmployeSituationStatutaireHistory $employeSituationStatutaireHistory)
    {
        $employeSituationStatutaireHistory->delete();

        return redirect()->route('employe_situation_statutaire_history.index')
            ->with('success', 'Historique situation statutaire supprimé avec succès.');
    }
}
