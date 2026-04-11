<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Http\Requests\RegionRequest;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::withCount(['provinces', 'modiriyas'])
            ->orderBy('LIB_REGION_FR')
            ->paginate(15);

        return view('regions.index', compact('regions'));
    }

    public function create()
    {
        return view('regions.create');
    }

    public function store(RegionRequest $request)
    {
        Region::create($request->validated());

        return redirect()->route('regions.index')
            ->with('success', 'Région créée avec succès.');
    }

    public function show(Region $region)
    {
        $region->load(['provinces.communes', 'modiriyas']);

        return view('regions.show', compact('region'));
    }

    public function edit(Region $region)
    {
        return view('regions.edit', compact('region'));
    }

    public function update(RegionRequest $request, Region $region)
    {
        $region->update($request->validated());

        return redirect()->route('regions.index')
            ->with('success', 'Région mise à jour avec succès.');
    }

    public function destroy(Region $region)
    {
        if ($region->provinces()->exists() || $region->modiriyas()->exists()) {
            return back()->with('error',
                'Impossible de supprimer : cette région contient des provinces ou modiriyas.');
        }

        $region->delete();

        return redirect()->route('regions.index')
            ->with('success', 'Région supprimée avec succès.');
    }
}
