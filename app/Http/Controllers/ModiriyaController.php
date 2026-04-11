<?php

namespace App\Http\Controllers;

use App\Models\Modiriya;
use App\Models\Region;
use App\Http\Requests\ModiriyaRequest;

class ModiriyaController extends Controller
{
    public function index()
    {
        $modiriyas = Modiriya::with('region')
            ->withCount('etablissements')
            ->orderBy('nom_modiriya')
            ->paginate(15);

        return view('modiriyas.index', compact('modiriyas'));
    }

    public function create()
    {
        $regions = Region::orderBy('LIB_REGION_FR')->get(['CD_REG', 'LIB_REGION_FR']);

        return view('modiriyas.create', compact('regions'));
    }

    public function store(ModiriyaRequest $request)
    {
        Modiriya::create($request->validated());

        return redirect()->route('modiriyas.index')
            ->with('success', 'Modiriya créée avec succès.');
    }

    public function show(Modiriya $modiriya)
    {
        $modiriya->load(['region', 'etablissements.commune.province']);

        return view('modiriyas.show', compact('modiriya'));
    }

    public function edit(Modiriya $modiriya)
    {
        $regions = Region::orderBy('LIB_REGION_FR')->get(['CD_REG', 'LIB_REGION_FR']);

        return view('modiriyas.edit', compact('modiriya', 'regions'));
    }

    public function update(ModiriyaRequest $request, Modiriya $modiriya)
    {
        $modiriya->update($request->validated());

        return redirect()->route('modiriyas.index')
            ->with('success', 'Modiriya mise à jour avec succès.');
    }

    public function destroy(Modiriya $modiriya)
    {
        if ($modiriya->etablissements()->exists()) {
            return back()->with('error',
                'Impossible de supprimer : cette modiriya contient des établissements.');
        }

        $modiriya->delete();

        return redirect()->route('modiriyas.index')
            ->with('success', 'Modiriya supprimée avec succès.');
    }
}
