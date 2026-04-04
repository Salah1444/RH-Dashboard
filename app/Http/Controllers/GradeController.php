<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Cadre;
use App\Models\Echelon;
use App\Models\EmployeGradesHistory;
use App\Models\EmployeCadreHistory;
use App\Models\EmployeEchelonHistory;
use App\Models\Employer;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /* ──── Grades référentiel ──── */
    public function index()
    {
        $grades  = Grade::withCount([
            'histories as effectif' => fn($q) => $q->latest('DAT_EFF_GR')->limit(1)
        ])->paginate(20);
        $cadres   = Cadre::paginate(20);
        $echelons = Echelon::paginate(20);
        $totalGrades  = Grade::count();
        $totalCadres  = Cadre::count();
        $totalEch     = Echelon::count();
        return view('grades.index', compact('grades', 'cadres', 'echelons', 'totalGrades', 'totalCadres', 'totalEch'));
    }

    public function storeGrade(Request $request)
    {
        $request->validate([
            'GRADE'        => 'required|string|max:50',
            'Lib_grade_FR' => 'required|string|max:200',
            'Lib_grade_AR' => 'nullable|string|max:200',
        ]);
        Grade::create($request->only('GRADE', 'Lib_grade_FR', 'Lib_grade_AR'));
        return redirect()->route('grades.index')->with('success', 'Grade créé.');
    }

    public function updateGrade(Request $request, Grade $grade)
    {
        $request->validate([
            'GRADE'        => 'required|string|max:50',
            'Lib_grade_FR' => 'required|string|max:200',
            'Lib_grade_AR' => 'nullable|string|max:200',
        ]);
        $grade->update($request->only('GRADE', 'Lib_grade_FR', 'Lib_grade_AR'));
        return redirect()->route('grades.index')->with('success', 'Grade mis à jour.');
    }

    public function destroyGrade(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('grades.index')->with('success', 'Grade supprimé.');
    }

    /* ──── Cadres référentiel ──── */
    public function storeCadre(Request $request)
    {
        $request->validate([
            'CADRE'        => 'required|string|max:50',
            'Lib_Cadre_FR' => 'required|string|max:200',
            'Lib_cadre_AR' => 'nullable|string|max:200',
        ]);
        Cadre::create($request->only('CADRE', 'Lib_Cadre_FR', 'Lib_cadre_AR'));
        return redirect()->route('grades.index')->with('success', 'Cadre créé.');
    }

    public function destroyCadre(Cadre $cadre)
    {
        $cadre->delete();
        return redirect()->route('grades.index')->with('success', 'Cadre supprimé.');
    }

    /* ──── Échelons référentiel ──── */
    public function storeEchelon(Request $request)
    {
        $request->validate([
            'COD_ECH' => 'required|string|max:20',
            'COD_ELO' => 'nullable|string|max:20',
        ]);
        Echelon::create($request->only('COD_ECH', 'COD_ELO'));
        return redirect()->route('grades.index')->with('success', 'Échelon créé.');
    }

    public function destroyEchelon(Echelon $echelon)
    {
        $echelon->delete();
        return redirect()->route('grades.index')->with('success', 'Échelon supprimé.');
    }

    /* ──── Historiques employé ──── */
    public function storeGradeHistory(Request $request)
    {
        $request->validate([
            'code_agent'    => 'required|exists:employer,COD_AG',
            'id_grade'      => 'required|exists:grade,id_grade',
            'ANC_GRADE'     => 'nullable|string|max:20',
            'DAT_EFF_GR'    => 'nullable|date',
            'MOD_AV_GRADE'  => 'nullable|string|max:100',
            'LIBELLE_GRADE' => 'nullable|string|max:200',
        ]);
        EmployeGradesHistory::create($request->all());
        return back()->with('success', 'Historique grade ajouté.');
    }

    public function storeCadreHistory(Request $request)
    {
        $request->validate([
            'code_agent'  => 'required|exists:employer,COD_AG',
            'id_cadre'    => 'required|exists:cadre,id_cadre',
            'ANC_ADM'     => 'nullable|string|max:20',
            'DT_AFF_Cadre'=> 'nullable|date',
        ]);
        EmployeCadreHistory::create($request->all());
        return back()->with('success', 'Historique cadre ajouté.');
    }
}