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
Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, ['fr', 'ar'], true)) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('locale.switch');
    Route::get('/',          [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    // employer 
    Route::prefix('employers')->name('employers.')->group(function () {

    // ── Routes sans paramètre ──────────────────────────────────
    Route::get('/index', [EmployerController::class, 'index'])->name('index');
    Route::get('/create', [EmployerController::class, 'create'])->name('create');
    Route::post('/store', [EmployerController::class, 'store'])->name('store');
    Route::get('/import/template', [EmployerController::class, 'importTemplate'])->name('import.template');
    Route::post('/import', [EmployerController::class, 'import'])->name('import');
    Route::get('/show', function () {
        $keyName = (new Employer())->getKeyName();
        $firstEmployerId = Employer::query()->orderBy($keyName)->value($keyName);
        abort_unless($firstEmployerId, 404, 'No employer record found.');
        return redirect()->route('employers.show', $firstEmployerId);
    })->name('show.default');
    Route::post('/update-photo/{id}', [EmployerController::class, 'updatePhoto'])
->name('photo.update');
    Route::get('/{id}/cv/export', [EmployerController::class, 'exportCV'])
        ->whereNumber('id')
        ->name('cv.export');         
    Route::get('/{id}', [EmployerController::class, 'show'])
        ->whereNumber('id')
        ->name('show');
});
    Route::resource('affectations',    AffectationController::class)->except(['show']);
    Route::resource('absences',        AbsenceController::class)->except(['show']);
    Route::resource('congees',         CongeeController::class)->except(['show']);
    Route::resource('etablissements',  EtablisementController::class);
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

    // Famille
    Route::get('/famille/conjoints',               [FamilleController::class, 'conjoints'])->name('famille.conjoints');
    Route::post('/famille/conjoints',              [FamilleController::class, 'storeConjoint'])->name('famille.conjoints.store');
    Route::delete('/famille/conjoints/{conjoint}', [FamilleController::class, 'destroyConjoint'])->name('famille.conjoints.destroy');
    Route::get('/famille/enfants',                 [FamilleController::class, 'enfants'])->name('famille.enfants');
    Route::post('/famille/enfants',                [FamilleController::class, 'storeEnfant'])->name('famille.enfants.store');
    Route::delete('/famille/enfants/{enfant}',     [FamilleController::class, 'destroyEnfant'])->name('famille.enfants.destroy');
});

require __DIR__.'/auth.php';