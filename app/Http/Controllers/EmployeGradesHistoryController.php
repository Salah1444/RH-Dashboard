<?php

namespace App\Http\Controllers;

use App\Models\EmployeGradesHistory;
use App\Models\Employer;
use App\Models\Grade;
use App\Http\Requests\EmployeGradesHistoryRequest;

class EmployeGradesHistoryController extends Controller
{
    public function index()
    {
        $histories = EmployeGradesHistory::with(['employe', 'grade'])
            ->orderByDesc('DAT_EFF_GR')
            ->paginate(20);

        return view('employe_grades_history.index', compact('histories'));
    }

    public function create()
    {
        $employes = Employer::orderBy('NOM_PRENOM_FR')->get(['COD_AG', 'NOM_PRENOM_FR', 'CIN']);
        $grades   = Grade::orderBy('Lib_grade_FR')->get(['id_grade', 'Lib_grade_FR', 'GRADE']);

        return view('employe_grades_history.create', compact('employes', 'grades'));
    }

    public function store(EmployeGradesHistoryRequest $request)
    {
        EmployeGradesHistory::create($request->validated());

        return redirect()->route('employe_grades_history.index')
            ->with('success', 'Historique grade ajouté avec succès.');
    }

    public function show(EmployeGradesHistory $employeGradesHistory)
    {
        $employeGradesHistory->load(['employe', 'grade']);

        return view('employe_grades_history.show', compact('employeGradesHistory'));
    }

    public function edit(EmployeGradesHistory $employeGradesHistory)
    {
        $employes = Employer::orderBy('NOM_PRENOM_FR')->get(['COD_AG', 'NOM_PRENOM_FR', 'CIN']);
        $grades   = Grade::orderBy('Lib_grade_FR')->get(['id_grade', 'Lib_grade_FR', 'GRADE']);

        return view('employe_grades_history.edit', compact('employeGradesHistory', 'employes', 'grades'));
    }

    public function update(EmployeGradesHistoryRequest $request, EmployeGradesHistory $employeGradesHistory)
    {
        $employeGradesHistory->update($request->validated());

        return redirect()->route('employe_grades_history.index')
            ->with('success', 'Historique grade mis à jour avec succès.');
    }

    public function destroy(EmployeGradesHistory $employeGradesHistory)
    {
        $employeGradesHistory->delete();

        return redirect()->route('employe_grades_history.index')
            ->with('success', 'Historique grade supprimé avec succès.');
    }
}
