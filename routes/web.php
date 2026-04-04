<?php

use App\Http\Controllers\EmployerController;
use App\Http\Controllers\ProfileController;
use App\Models\Employer;
use Illuminate\Support\Facades\Route;


Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, ['fr', 'ar'], true)) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('locale.switch');

// Page d'accueil → redirige vers la liste des employés
Route::get('/', [EmployerController::class, 'index'])->middleware(['auth', 'verified']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('employers')->name('employers.')->middleware(['auth', 'verified'])->group(function () {

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

require __DIR__.'/auth.php';