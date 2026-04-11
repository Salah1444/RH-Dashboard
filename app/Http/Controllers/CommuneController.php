<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\Province;
use App\Http\Requests\CommuneRequest;

class CommuneController extends Controller
{
    public function index()
    {
        $communes = Commune::with('province.region')
            ->withCount('etablissements')
            ->orderBy('LIB_COMMUNE_FR')
            ->paginate(20);

        return view('communes.index', compact('communes'));
    }

    public function create()
    {
        $provinces = Province::with('region')
            ->orderBy('LIB_PROVINCE_FR')
            ->get(['CD_PRV', 'LIB_PROVINCE_FR', 'CD_REG']);

        return view('communes.create', compact('provinces'));
    }

    public function store(CommuneRequest $request)
    {
        Commune::create($request->validated());

        return redirect()->route('communes.index')
            ->with('success', 'Commune créée avec succès.');
    }

    public function show(Commune $commune)
    {
        $commune->load(['province.region', 'etablissements']);

        return view('communes.show', compact('commune'));
    }

    public function edit(Commune $commune)
    {
        $provinces = Province::with('region')
            ->orderBy('LIB_PROVINCE_FR')
            ->get(['CD_PRV', 'LIB_PROVINCE_FR', 'CD_REG']);

        return view('communes.edit', compact('commune', 'provinces'));
    }

    public function update(CommuneRequest $request, Commune $commune)
    {
        $commune->update($request->validated());

        return redirect()->route('communes.index')
            ->with('success', 'Commune mise à jour avec succès.');
    }

    public function destroy(Commune $commune)
    {
        if ($commune->etablissements()->exists()) {
            return back()->with('error',
                'Impossible de supprimer : cette commune contient des établissements.');
        }

        $commune->delete();

        return redirect()->route('communes.index')
            ->with('success', 'Commune supprimée avec succès.');
    }
}
