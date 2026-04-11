<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Region;
use App\Http\Requests\ProvinceRequest;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::with('region')
            ->withCount('communes')
            ->orderBy('LIB_PROVINCE_FR')
            ->paginate(15);

        return view('provinces.index', compact('provinces'));
    }

    public function create()
    {
        $regions = Region::orderBy('LIB_REGION_FR')->get(['CD_REG', 'LIB_REGION_FR']);

        return view('provinces.create', compact('regions'));
    }

    public function store(ProvinceRequest $request)
    {
        Province::create($request->validated());

        return redirect()->route('provinces.index')
            ->with('success', 'Province créée avec succès.');
    }

    public function show(Province $province)
    {
        $province->load(['region', 'communes']);

        return view('provinces.show', compact('province'));
    }

    public function edit(Province $province)
    {
        $regions = Region::orderBy('LIB_REGION_FR')->get(['CD_REG', 'LIB_REGION_FR']);

        return view('provinces.edit', compact('province', 'regions'));
    }

    public function update(ProvinceRequest $request, Province $province)
    {
        $province->update($request->validated());

        return redirect()->route('provinces.index')
            ->with('success', 'Province mise à jour avec succès.');
    }

    public function destroy(Province $province)
    {
        if ($province->communes()->exists()) {
            return back()->with('error',
                'Impossible de supprimer : cette province contient des communes.');
        }

        $province->delete();

        return redirect()->route('provinces.index')
            ->with('success', 'Province supprimée avec succès.');
    }
}
