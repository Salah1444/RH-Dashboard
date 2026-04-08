<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\CongeeController;
use App\Http\Controllers\EtablisementController;
use App\Http\Controllers\DiplomeController;
use App\Http\Controllers\FamilleController;
use App\Http\Controllers\GradeController;

Route::middleware(['auth'])->group(function () {

    Route::get('/',          [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');


   
    // Employés
    Route::resource('employes',        EmployerController::class);
    Route::get('employes/{id}/cv/export',   [EmployerController::class, 'exportCV'])->whereNumber('id')->name('employes.cv.export');
    Route::post('employes/import',          [EmployerController::class, 'importExcel'])->name('employes.import');
    Route::get('employes/template',         [EmployerController::class, 'downloadTemplate'])->name('employes.template');
    
    // Affectations
    Route::resource('affectations',    AffectationController::class)->except(['show']);
    Route::post('affectations/import', [AffectationController::class, 'importExcel'])->name('affectations.import');
    Route::get('affectations/template',[AffectationController::class, 'downloadTemplate'])->name('affectations.template');

    Route::resource('absences',        AbsenceController::class)->except(['show']);
    Route::resource('congees',         CongeeController::class)->except(['show']);

    // Établissements
    Route::resource('etablissements',  EtablisementController::class);
    Route::post('etablissements/import', [EtablisementController::class, 'importExcel'])->name('etablissements.import');
    Route::get('etablissements/template',[EtablisementController::class, 'downloadTemplate'])->name('etablissements.template');

    // Diplômes
    Route::resource('diplomes',        DiplomeController::class)->except(['show']);
    Route::post('diplomes/import',     [DiplomeController::class, 'importExcel'])->name('diplomes.import');
    Route::get('diplomes/template',    [DiplomeController::class, 'downloadTemplate'])->name('diplomes.template');


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

    // Grades/Cadres/Échelons Excel
    Route::post('/grades/import',          [GradeController::class, 'importGrades'])->name('grades.import');
    Route::get('/grades/template',         [GradeController::class, 'downloadGradesTemplate'])->name('grades.template');
    Route::post('/cadres/import',          [GradeController::class, 'importCadres'])->name('cadres.import');
    Route::get('/cadres/template',         [GradeController::class, 'downloadCadresTemplate'])->name('cadres.template');
    Route::post('/echelons/import',        [GradeController::class, 'importEchelons'])->name('echelons.import');
    Route::get('/echelons/template',       [GradeController::class, 'downloadEchelonsTemplate'])->name('echelons.template');


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

require __DIR__.'/auth.php';