<?php

namespace App\Http\Controllers;

use App\Models\NetEtab;
use App\Http\Requests\NetEtabRequest;

class NetEtabController extends Controller
{
    public function index()
    {
        $netEtabs = NetEtab::withCount('etablissements')
            ->orderBy('LIBELLE_net_etab')
            ->paginate(15);

        return view('net_etabs.index', compact('netEtabs'));
    }

    public function create()
    {
        return view('net_etabs.create');
    }

    public function store(NetEtabRequest $request)
    {
        NetEtab::create($request->validated());

        return redirect()->route('net_etabs.index')
            ->with('success', 'Réseau d\'établissement créé avec succès.');
    }

    public function show(NetEtab $netEtab)
    {
        $netEtab->load('etablissements.commune.province.region');

        return view('net_etabs.show', compact('netEtab'));
    }

    public function edit(NetEtab $netEtab)
    {
        return view('net_etabs.edit', compact('netEtab'));
    }

    public function update(NetEtabRequest $request, NetEtab $netEtab)
    {
        $netEtab->update($request->validated());

        return redirect()->route('net_etabs.index')
            ->with('success', 'Réseau d\'établissement mis à jour avec succès.');
    }

    public function destroy(NetEtab $netEtab)
    {
        if ($netEtab->etablissements()->exists()) {
            return back()->with('error',
                'Impossible de supprimer : ce réseau contient des établissements.');
        }

        $netEtab->delete();

        return redirect()->route('net_etabs.index')
            ->with('success', 'Réseau d\'établissement supprimé avec succès.');
    }
}
