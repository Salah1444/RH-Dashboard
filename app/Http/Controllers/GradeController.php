<?php

namespace App\Http\Controllers;

use App\Exports\CadreHistoryImportTemplate;
use App\Models\Grade;
use App\Models\Cadre;
use App\Models\Echelon;
use App\Models\Employer;
use App\Models\SituationStatutaire;
use App\Models\EmployeGradesHistory;
use App\Models\EmployeCadreHistory;
use App\Models\EmployeEchelonHistory;
use App\Models\EmployeSituationStatutaireHistory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GradesImport;
use App\Imports\CadresImport;
use App\Imports\EchelonsImport;
use App\Exports\GradesImportTemplate;
use App\Exports\CadresImportTemplate;
use App\Exports\EchelonHistoryImportTemplate;
use App\Exports\EchelonsImportTemplate;
use App\Exports\GradeHistoryImportTemplate;
use App\Imports\CadreHistoryImport;
use App\Imports\EchelonHistoryImport;
use App\Imports\GradeHistoryImport;
use App\Imports\SituationsImport;
use App\Exports\SituationsImportTemplate;

class GradeController extends Controller
{
    // ────────────────────────────────────────────────────────────
    // INDEX — page principale référentiels
    // ────────────────────────────────────────────────────────────
    public function index()
    {
        $grades    = Grade::paginate(20);
        $cadres    = Cadre::paginate(20);
        $echelons  = Echelon::paginate(20);
        $totalGrades = Grade::count();
        $totalCadres = Cadre::count();
        $totalEch    = Echelon::count();
        $employes   = Employer::orderBy('NOM_PRENOM_FR')->get(['COD_AG','NOM_PRENOM_FR']);
$allGrades  = Grade::orderBy('Lib_grade_FR')->get();
$allCadres  = Cadre::orderBy('Lib_Cadre_FR')->get();
$allEchelons= Echelon::orderBy('COD_ECH')->get();
        $gradeHistories   = EmployeGradesHistory::with(['employer', 'grade'])
                                ->latest()->paginate(10);
        $cadreHistories   = EmployeCadreHistory::with(['employer', 'cadre'])
                                ->latest()->paginate(10);
        $echelonHistories = EmployeEchelonHistory::with(['employer', 'echelon'])
                                ->latest()->paginate(10);

        return view('grades.index', compact(
            'grades', 'cadres', 'echelons',
            'totalGrades', 'totalCadres', 'totalEch',
            'gradeHistories', 'cadreHistories', 'echelonHistories','employes','allCadres','allEchelons','allGrades'
        ));
    }

    // ────────────────────────────────────────────────────────────
    // GRADES RÉFÉRENTIEL
    // ────────────────────────────────────────────────────────────
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
        if ($grade->history()->exists()) {
            return back()->with('error', 'Impossible : ce grade est utilisé dans des historiques.');
        }
        $grade->delete();
        return redirect()->route('grades.index')->with('success', 'Grade supprimé.');
    }

    // ────────────────────────────────────────────────────────────
    // CADRES RÉFÉRENTIEL
    // ────────────────────────────────────────────────────────────
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

    public function updateCadre(Request $request, Cadre $cadre)
    {
        $request->validate([
            'CADRE'        => 'required|string|max:50',
            'Lib_Cadre_FR' => 'required|string|max:200',
            'Lib_cadre_AR' => 'nullable|string|max:200',
        ]);
        $cadre->update($request->only('CADRE', 'Lib_Cadre_FR', 'Lib_cadre_AR'));
        return redirect()->route('grades.index')->with('success', 'Cadre mis à jour.');
    }

    public function destroyCadre(Cadre $cadre)
    {
        if ($cadre->history()->exists()) {
            return back()->with('error', 'Impossible : ce cadre est utilisé dans des historiques.');
        }
        $cadre->delete();
        return redirect()->route('grades.index')->with('success', 'Cadre supprimé.');
    }

    // ────────────────────────────────────────────────────────────
    // ÉCHELONS RÉFÉRENTIEL
    // ────────────────────────────────────────────────────────────
    public function storeEchelon(Request $request)
    {
        $request->validate([
            'COD_ECH' => 'required|string|max:20',
            'COD_ELO' => 'nullable|string|max:20',
        ]);
        Echelon::create($request->only('COD_ECH', 'COD_ELO'));
        return redirect()->route('grades.index')->with('success', 'Échelon créé.');
    }

    public function updateEchelon(Request $request, Echelon $echelon)
    {
        $request->validate([
            'COD_ECH' => 'required|string|max:20',
            'COD_ELO' => 'nullable|string|max:20',
        ]);
        $echelon->update($request->only('COD_ECH', 'COD_ELO'));
        return redirect()->route('grades.index')->with('success', 'Échelon mis à jour.');
    }

    public function destroyEchelon(Echelon $echelon)
    {
        if ($echelon->history()->exists()) {
            return back()->with('error', 'Impossible : cet échelon est utilisé dans des historiques.');
        }
        $echelon->delete();
        return redirect()->route('grades.index')->with('success', 'Échelon supprimé.');
    }

    // ────────────────────────────────────────────────────────────
    // SITUATION STATUTAIRE RÉFÉRENTIEL  (nouveau)
    // ────────────────────────────────────────────────────────────
    public function indexSituations()
    {
        $allSituations = SituationStatutaire::all(); 
        $situations       = SituationStatutaire::withCount('histories')->paginate(20);
        $sitHistories     = EmployeSituationStatutaireHistory::with(['employer', 'situationStatutaire'])
                                ->latest()->paginate(15);
        $employers        = Employer::orderBy('NOM_PRENOM_FR')->get(['COD_AG', 'NOM_PRENOM_FR']);
        $totalSituations  = SituationStatutaire::count();

        return view('situation_statutaire.index', compact(
            'situations', 'sitHistories', 'employers', 'totalSituations','allSituations'
        ));
    }

    public function storeSituation(Request $request)
    {
        $request->validate([
            'CODE_SIT_STATUTAIRE'        => 'required|string|max:30|unique:situation_statutaire,CODE_SIT_STATUTAIRE',
            'LIB_SITUATION_STATUTAIRE_FR' => 'required|string|max:200',
            'LIB_SITUATION_STATUTAIRE_AR' => 'nullable|string|max:200',
        ]);
        SituationStatutaire::create($request->only(
            'CODE_SIT_STATUTAIRE',
            'LIB_SITUATION_STATUTAIRE_FR',
            'LIB_SITUATION_STATUTAIRE_AR'
        ));
        return redirect()->route('situations.index')->with('success', 'Situation statutaire créée.');
    }

    public function updateSituation(Request $request, SituationStatutaire $situation)
    {
        $request->validate([
            'CODE_SIT_STATUTAIRE'        => 'required|string|max:30|unique:situation_statutaire,CODE_SIT_STATUTAIRE,' . $situation->sit_st_id . ',sit_st_id',
            'LIB_SITUATION_STATUTAIRE_FR' => 'required|string|max:200',
            'LIB_SITUATION_STATUTAIRE_AR' => 'nullable|string|max:200',
        ]);
        $situation->update($request->only(
            'CODE_SIT_STATUTAIRE',
            'LIB_SITUATION_STATUTAIRE_FR',
            'LIB_SITUATION_STATUTAIRE_AR'
        ));
        return redirect()->route('situations.index')->with('success', 'Situation statutaire mise à jour.');
    }

    public function destroySituation(SituationStatutaire $situation)
    {
        if ($situation->histories()->exists()) {
            return back()->with('error', 'Impossible : cette situation est utilisée dans des historiques.');
        }
        $situation->delete();
        return redirect()->route('situations.index')->with('success', 'Situation supprimée.');
    }

    // ────────────────────────────────────────────────────────────
    // HISTORIQUE GRADE
    // ────────────────────────────────────────────────────────────
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
        EmployeGradesHistory::create($request->only(
            'code_agent', 'id_grade', 'ANC_GRADE',
            'DAT_EFF_GR', 'MOD_AV_GRADE', 'LIBELLE_GRADE'
        ));
        return back()->with('success', 'Historique grade ajouté.');
    }

    public function updateGradeHistory(Request $request, EmployeGradesHistory $gradeHistory)
    {
        $request->validate([
            'code_agent'    => 'required|exists:employer,COD_AG',
            'id_grade'      => 'required|exists:grade,id_grade',
            'ANC_GRADE'     => 'nullable|string|max:20',
            'DAT_EFF_GR'    => 'nullable|date',
            'MOD_AV_GRADE'  => 'nullable|string|max:100',
            'LIBELLE_GRADE' => 'nullable|string|max:200',
        ]);
        $gradeHistory->update($request->only(
            'code_agent', 'id_grade', 'ANC_GRADE',
            'DAT_EFF_GR', 'MOD_AV_GRADE', 'LIBELLE_GRADE'
        ));
        return back()->with('success', 'Historique grade mis à jour.');
    }

    public function destroyGradeHistory(EmployeGradesHistory $gradeHistory)
    {
        $gradeHistory->delete();
        return back()->with('success', 'Historique grade supprimé.');
    }

    // ────────────────────────────────────────────────────────────
    // HISTORIQUE CADRE
    // ────────────────────────────────────────────────────────────
    public function storeCadreHistory(Request $request)
    {
        $request->validate([
            'code_agent'   => 'required|exists:employer,COD_AG',
            'id_cadre'     => 'required|exists:cadre,id_cadre',
            'ANC_ADM'      => 'nullable|string|max:20',
            'DT_AFF_Cadre' => 'nullable|date',
        ]);
        EmployeCadreHistory::create($request->only(
            'code_agent', 'id_cadre', 'ANC_ADM', 'DT_AFF_Cadre'
        ));
        return back()->with('success', 'Historique cadre ajouté.');
    }

    public function updateCadreHistory(Request $request, EmployeCadreHistory $cadreHistory)
    {
        $request->validate([
            'code_agent'   => 'required|exists:employer,COD_AG',
            'id_cadre'     => 'required|exists:cadre,id_cadre',
            'ANC_ADM'      => 'nullable|string|max:20',
            'DT_AFF_Cadre' => 'nullable|date',
        ]);
        $cadreHistory->update($request->only(
            'code_agent', 'id_cadre', 'ANC_ADM', 'DT_AFF_Cadre'
        ));
        return back()->with('success', 'Historique cadre mis à jour.');
    }

    public function destroyCadreHistory(EmployeCadreHistory $cadreHistory)
    {
        $cadreHistory->delete();
        return back()->with('success', 'Historique cadre supprimé.');
    }

    // ────────────────────────────────────────────────────────────
    // HISTORIQUE ÉCHELON
    // ────────────────────────────────────────────────────────────
    public function storeEchelonHistory(Request $request)
    {
        $request->validate([
            'code_agent'  => 'required|exists:employer,COD_AG',
            'id_ech'      => 'required|exists:echelon,id_ech',
            'INDICE'      => 'nullable|string|max:20',
            'DAT_EFF_ELO' => 'nullable|date',
        ]);
        EmployeEchelonHistory::create($request->only(
            'code_agent', 'id_ech', 'INDICE', 'DAT_EFF_ELO'
        ));
        return back()->with('success', 'Historique échelon ajouté.');
    }

    public function updateEchelonHistory(Request $request, EmployeEchelonHistory $echelonHistory)
    {
        $request->validate([
            'code_agent'  => 'required|exists:employer,COD_AG',
            'id_ech'      => 'required|exists:echelon,id_ech',
            'INDICE'      => 'nullable|string|max:20',
            'DAT_EFF_ELO' => 'nullable|date',
        ]);
        $echelonHistory->update($request->only(
            'code_agent', 'id_ech', 'INDICE', 'DAT_EFF_ELO'
        ));
        return back()->with('success', 'Historique échelon mis à jour.');
    }

    public function destroyEchelonHistory(EmployeEchelonHistory $echelonHistory)
    {
        $echelonHistory->delete();
        return back()->with('success', 'Historique échelon supprimé.');
    }

    // ────────────────────────────────────────────────────────────
    // HISTORIQUE SITUATION STATUTAIRE
    // ────────────────────────────────────────────────────────────
    public function storeSituationHistory(Request $request)
    {
        $request->validate([
            'code_agent'        => 'required|exists:employer,COD_AG',
            'sit_st_id'         => 'required|exists:situation_statutaire,sit_st_id',
            'DATE_SIT_STAT'     => 'nullable|date',
            'DATE_PREV_RETRAITE'=> 'nullable|date|after_or_equal:DATE_SIT_STAT',
        ]);
        EmployeSituationStatutaireHistory::create($request->only(
            'code_agent', 'sit_st_id', 'DATE_SIT_STAT', 'DATE_PREV_RETRAITE'
        ));
        return back()->with('success', 'Historique situation statutaire ajouté.');
    }

    public function updateSituationHistory(Request $request, EmployeSituationStatutaireHistory $situationHistory)
    {
        $request->validate([
            'code_agent'        => 'required|exists:employer,COD_AG',
            'sit_st_id'         => 'required|exists:situation_statutaire,sit_st_id',
            'DATE_SIT_STAT'     => 'nullable|date',
            'DATE_PREV_RETRAITE'=> 'nullable|date|after_or_equal:DATE_SIT_STAT',
        ]);
        $situationHistory->update($request->only(
            'code_agent', 'sit_st_id', 'DATE_SIT_STAT', 'DATE_PREV_RETRAITE'
        ));
        return back()->with('success', 'Historique mis à jour.');
    }

    public function destroySituationHistory(EmployeSituationStatutaireHistory $situationHistory)
    {
        $situationHistory->delete();
        return back()->with('success', 'Historique supprimé.');
    }

    public function importSituationHistories(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:xlsx,xls,csv']);
        try {
            Excel::import(new \App\Imports\SituationHistoriesImport(), $request->file('file'));
            return back()->with('success', 'Historiques importés avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'import: ' . $e->getMessage());
        }
    }

    public function downloadSituationHistoriesTemplate()
    {
        return Excel::download(new \App\Exports\SituationHistoriesImportTemplate(), 'situation-histories-template.xlsx');
    }

    // ────────────────────────────────────────────────────────────
    // IMPORT / EXPORT EXCEL (inchangés)
    // ────────────────────────────────────────────────────────────
    public function importGrades(Request $request)
    {
        $request->validate(['excel_file' => 'required|file|mimes:xlsx,xls,csv']);
        try {
            Excel::import(new GradesImport, $request->file('excel_file'));
            return redirect()->route('grades.index')->with('success', 'Grades importés.');
        } catch (\Throwable $e) {
            return redirect()->route('grades.index')->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function downloadGradesTemplate()
    {
        return Excel::download(new GradesImportTemplate, 'modele_grades.xlsx');
    }

    public function importCadres(Request $request)
    {
        $request->validate(['excel_file' => 'required|file|mimes:xlsx,xls,csv']);
        try {
            Excel::import(new CadresImport, $request->file('excel_file'));
            return redirect()->route('grades.index')->with('success', 'Cadres importés.');
        } catch (\Throwable $e) {
            return redirect()->route('grades.index')->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function downloadCadresTemplate()
    {
        return Excel::download(new CadresImportTemplate, 'modele_cadres.xlsx');
    }

    public function importEchelons(Request $request)
    {
        $request->validate(['excel_file' => 'required|file|mimes:xlsx,xls,csv']);
        try {
            Excel::import(new EchelonsImport, $request->file('excel_file'));
            return redirect()->route('grades.index')->with('success', 'Échelons importés.');
        } catch (\Throwable $e) {
            return redirect()->route('grades.index')->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function downloadEchelonsTemplate()
    {
        return Excel::download(new EchelonsImportTemplate, 'modele_echelons.xlsx');
    }

    public function importSituations(Request $request)
    {
        $request->validate(['excel_file' => 'required|file|mimes:xlsx,xls,csv']);
        try {
            Excel::import(new SituationsImport, $request->file('excel_file'));
            return redirect()->route('situations.index')->with('success', 'Situations importées.');
        } catch (\Throwable $e) {
            return redirect()->route('situations.index')->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function downloadSituationsTemplate()
    {
        return Excel::download(new SituationsImportTemplate, 'modele_situations.xlsx');
    }

    public function importGradeHistory(Request $request)
    {
        $request->validate(['excel_file' => 'required|file|mimes:xlsx,xls,csv']);
        try {
            Excel::import(new GradeHistoryImport, $request->file('excel_file'));
            return redirect()->route('grades.index')->with('success', 'Historiques grades importés.');
        } catch (\Throwable $e) {
            return redirect()->route('grades.index')->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function downloadGradeHistoryTemplate()
    {
        return Excel::download(new GradeHistoryImportTemplate, 'modele_historique_grades.xlsx');
    }

    // ────────────────────────────────────────────────────────────
    // IMPORT / EXPORT HISTORIQUE CADRE
    // ────────────────────────────────────────────────────────────
    public function importCadreHistory(Request $request)
    {
        $request->validate(['excel_file' => 'required|file|mimes:xlsx,xls,csv']);
        try {
            Excel::import(new CadreHistoryImport, $request->file('excel_file'));
            return redirect()->route('grades.index')->with('success', 'Historiques cadres importés.');
        } catch (\Throwable $e) {
            return redirect()->route('grades.index')->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function downloadCadreHistoryTemplate()
    {
        return Excel::download(new CadreHistoryImportTemplate, 'modele_historique_cadres.xlsx');
    }

    // ────────────────────────────────────────────────────────────
    // IMPORT / EXPORT HISTORIQUE ÉCHELON
    // ────────────────────────────────────────────────────────────
    public function importEchelonHistory(Request $request)
    {
        $request->validate(['excel_file' => 'required|file|mimes:xlsx,xls,csv']);
        try {
            Excel::import(new EchelonHistoryImport, $request->file('excel_file'));
            return redirect()->route('grades.index')->with('success', 'Historiques échelons importés.');
        } catch (\Throwable $e) {
            return redirect()->route('grades.index')->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    public function downloadEchelonHistoryTemplate()
    {
        return Excel::download(new EchelonHistoryImportTemplate, 'modele_historique_echelons.xlsx');
    }

}
