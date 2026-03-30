<?php

use App\Http\Controllers\EmployerController;
use App\Http\Controllers\ProfileController;
use App\Models\Employer;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [EmployerController::class, 'index'])->middleware(['auth', 'verified']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::prefix('employers')->name('employers.')->group(function () {
    Route::get('/index',      [EmployerController::class, 'index'])->name('index');
    Route::get('/show', function () {
        $keyName = (new Employer())->getKeyName();
        $firstEmployerId = Employer::query()->orderBy($keyName)->value($keyName);

        abort_unless($firstEmployerId, 404, 'No employer record found.');

        return redirect()->route('employers.show', $firstEmployerId);
    })->name('show.default');
    Route::get('/{id}',  [EmployerController::class, 'show'])->whereNumber('id')->name('show');
})->middleware(['auth','verified']);

require __DIR__.'/auth.php';
