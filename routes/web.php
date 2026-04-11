<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\CommuneController;
use App\Http\Controllers\CongeeController;
use App\Http\Controllers\EtablisementController;
use App\Http\Controllers\DiplomeController;
use App\Http\Controllers\FamilleController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ModiriyaController;
use App\Http\Controllers\NetEtabController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RegionController;


Route::middleware(['auth'])->group(function () {

    Route::get('/',          [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');


    // ── Géographie ──────────────────────────────────────────
    Route::resource('regions',   RegionController::class);
    Route::resource('provinces', ProvinceController::class);
    Route::resource('communes',  CommuneController::class);

    // ── Organisation ────────────────────────────────────────
    Route::resource('modiriyas', ModiriyaController::class);
    Route::resource('net_etabs', NetEtabController::class);

    // Employés — custom routes BEFORE resource() to prevent {employe} swallowing them
    Route::get('employes/template',         [EmployerController::class, 'downloadTemplate'])->name('employes.template');
    Route::post('employes/import',          [EmployerController::class, 'importExcel'])->name('employes.import');
    Route::post('employes/update-photo',          [EmployerController::class, 'updatePhoto'])->name('employes.photo.update');
    Route::get('employes/export',           [EmployerController::class, 'exportExcel'])->name('employes.export');
    Route::resource('employes',             EmployerController::class);
    Route::get('employes/{id}/cv/export',   [EmployerController::class, 'exportCV'])->whereNumber('id')->name('employes.cv.export');

    // Affectations — custom routes BEFORE resource()
    Route::get('affectations/template',  [AffectationController::class, 'downloadTemplate'])->name('affectations.template');
    Route::post('affectations/import',   [AffectationController::class, 'importExcel'])->name('affectations.import');
    Route::resource('affectations',      AffectationController::class)->except(['show']);

    Route::resource('absences',        AbsenceController::class)->except(['show']);
    Route::resource('congees',         CongeeController::class)->except(['show']);


    // Établissements — custom routes BEFORE resource()
    Route::get('etablissements/template',  [EtablisementController::class, 'downloadTemplate'])->name('etablissements.template');
    Route::post('etablissements/import',   [EtablisementController::class, 'importExcel'])->name('etablissements.import');
    Route::resource('etablissements',      EtablisementController::class);

    // Diplômes — custom routes BEFORE resource()
    Route::get('diplomes/template',    [DiplomeController::class, 'downloadTemplate'])->name('diplomes.template');
    Route::post('diplomes/import',     [DiplomeController::class, 'importExcel'])->name('diplomes.import');
    Route::resource('diplomes',        DiplomeController::class)->except(['show']);


    // Grades / Cadres / Échelons
    Route::get('/grades',                  [GradeController::class, 'index'])->name('grades.index');
    Route::post('/grades',                 [GradeController::class, 'storeGrade'])->name('grades.store');
    Route::put('/grades/{grade}',          [GradeController::class, 'updateGrade'])->name('grades.update');
    Route::delete('/grades/{grade}',       [GradeController::class, 'destroyGrade'])->name('grades.destroy');
    Route::post('/cadres',                 [GradeController::class, 'storeCadre'])->name('cadres.store');
    Route::delete('/cadres/{cadre}',       [GradeController::class, 'destroyCadre'])->name('cadres.destroy');
    Route::post('/echelons',               [GradeController::class, 'storeEchelon'])->name('echelons.store');
    Route::delete('/echelons/{echelon}',   [GradeController::class, 'destroyEchelon'])->name('echelons.destroy');
    Route::post('/grades-history',         [GradeController::class, 'storeGradeHistory'])->name('grades.history.store');
    Route::post('/cadres-history',         [GradeController::class, 'storeCadreHistory'])->name('cadres.history.store');
// ── Historiques RH ──────────────────────────────────────
    Route::put('/cadres/{cadre}',            [GradeController::class, 'updateCadre'])->name('cadres.update');
Route::put('/echelons/{echelon}',        [GradeController::class, 'updateEchelon'])->name('echelons.update');

// ── GRADE HISTORY (new)
Route::put('/grades-history/{gradeHistory}',   [GradeController::class, 'updateGradeHistory'])->name('grades.history.update');
Route::delete('/grades-history/{gradeHistory}',[GradeController::class, 'destroyGradeHistory'])->name('grades.history.destroy');

// ── CADRE HISTORY (new)
Route::put('/cadres-history/{cadreHistory}',   [GradeController::class, 'updateCadreHistory'])->name('cadres.history.update');
Route::delete('/cadres-history/{cadreHistory}',[GradeController::class, 'destroyCadreHistory'])->name('cadres.history.destroy');

// ── ECHELON HISTORY (new)
Route::post('/echelons-history',               [GradeController::class, 'storeEchelonHistory'])->name('echelons.history.store');
Route::put('/echelons-history/{echelonHistory}',[GradeController::class, 'updateEchelonHistory'])->name('echelons.history.update');
Route::delete('/echelons-history/{echelonHistory}',[GradeController::class, 'destroyEchelonHistory'])->name('echelons.history.destroy');

// ── SITUATION STATUTAIRE (new page)
Route::get('/situations',                      [GradeController::class, 'indexSituations'])->name('situations.index');
Route::post('/situations',                     [GradeController::class, 'storeSituation'])->name('situations.store');
Route::post('/situations/import',              [GradeController::class, 'importSituations'])->name('situations.import');
Route::get('/situations/template',             [GradeController::class, 'downloadSituationsTemplate'])->name('situations.template');
Route::put('/situations/{situation}',          [GradeController::class, 'updateSituation'])->name('situations.update');
Route::delete('/situations/{situation}',       [GradeController::class, 'destroySituation'])->name('situations.destroy');

// ── SITUATION HISTORY (new)
Route::post('/situations-history',             [GradeController::class, 'storeSituationHistory'])->name('situations.history.store');
Route::put('/situations-history/{situationHistory}', [GradeController::class, 'updateSituationHistory'])->name('situations.history.update');
Route::delete('/situations-history/{situationHistory}',[GradeController::class, 'destroySituationHistory'])->name('situations.history.destroy');
Route::post('/situations-history/import',      [GradeController::class, 'importSituationHistories'])->name('situations.history.import');
Route::get('/situations-history/template',     [GradeController::class, 'downloadSituationHistoriesTemplate'])->name('situations.history.template');


    // Grades/Cadres/Échelons Excel
    Route::post('/grades/import',          [GradeController::class, 'importGrades'])->name('grades.import');
    Route::get('/grades/template',         [GradeController::class, 'downloadGradesTemplate'])->name('grades.template');
    Route::post('/cadres/import',          [GradeController::class, 'importCadres'])->name('cadres.import');
    Route::get('/cadres/template',         [GradeController::class, 'downloadCadresTemplate'])->name('cadres.template');
    Route::post('/echelons/import',        [GradeController::class, 'importEchelons'])->name('echelons.import');
    Route::get('/echelons/template',       [GradeController::class, 'downloadEchelonsTemplate'])->name('echelons.template');

    
// IMPORT historique grades
Route::post('/grades-history/import',          [GradeController::class, 'importGradeHistory'])->name('grades.history.import');
Route::get('/grades-history/template',         [GradeController::class, 'downloadGradeHistoryTemplate'])->name('grades.history.template');

// IMPORT historique cadres
Route::post('/cadres-history/import',          [GradeController::class, 'importCadreHistory'])->name('cadres.history.import');
Route::get('/cadres-history/template',         [GradeController::class, 'downloadCadreHistoryTemplate'])->name('cadres.history.template');

// IMPORT historique échelons
Route::post('/echelons-history/import',        [GradeController::class, 'importEchelonHistory'])->name('echelons.history.import');
Route::get('/echelons-history/template',       [GradeController::class, 'downloadEchelonHistoryTemplate'])->name('echelons.history.template');


    // Famille
    Route::get('/famille/conjoints',               [FamilleController::class, 'conjoints'])->name('famille.conjoints');
    Route::post('/famille/conjoints',              [FamilleController::class, 'storeConjoint'])->name('famille.conjoints.store');
    Route::delete('/famille/conjoints/{conjoint}', [FamilleController::class, 'destroyConjoint'])->name('famille.conjoints.destroy');
    Route::get('/famille/enfants',                 [FamilleController::class, 'enfants'])->name('famille.enfants');
    Route::post('/famille/enfants',                [FamilleController::class, 'storeEnfant'])->name('famille.enfants.store');
    Route::delete('/famille/enfants/{enfant}',     [FamilleController::class, 'destroyEnfant'])->name('famille.enfants.destroy');

    // Famille Excel
    Route::post('/famille/conjoints/import',       [FamilleController::class, 'importConjoints'])->name('famille.conjoints.import');
    Route::get('/famille/conjoints/template',      [FamilleController::class, 'downloadConjointsTemplate'])->name('famille.conjoints.template');
    Route::post('/famille/enfants/import',         [FamilleController::class, 'importEnfants'])->name('famille.enfants.import');
    Route::get('/famille/enfants/template',        [FamilleController::class, 'downloadEnfantsTemplate'])->name('famille.enfants.template');
});

require __DIR__ . '/auth.php';
