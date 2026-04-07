<?php

namespace App\Http\Controllers;

use App\Models\Etablisement;
use App\Models\Commune;
use App\Models\Modiriya;
use App\Models\NetEtab;
use Illuminate\Http\Request;

class EtablisementController extends Controller
{
    public function index(Request $request)
    {
        $query = Etablisement::with(['commune.province.region', 'modiriya', 'netEtab']);

        if ($request->filled('search')) {
            $query->where('NOM_ETAB', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('milieu')) {
            $query->where('type_milieu', $request->milieu);
        }
        if ($request->filled('modiriya')) {
            $query->where('modiriya_id', $request->modiriya);
        }

        $etablissements = $query->paginate(15)->withQueryString();
        $modiriyas      = Modiriya::orderBy('nom_modiriya')->get();
        $totalEtab      = Etablisement::count();
        $urbains        = Etablisement::where('type_milieu', 'Urbain')->count();
        $ruraux         = Etablisement::where('type_milieu', 'Rural')->count();
        $avecLogement   = Etablisement::where('Disponibilite_logement', 'Oui')->count();

        return view('etablissements.index', compact(
            'etablissements', 'modiriyas',
            'totalEtab', 'urbains', 'ruraux', 'avecLogement'
        ));
    }

    public function create()
    {
        $communes  = Commune::orderBy('LIB_COMMUNE_FR')->get();
        $modiriyas = Modiriya::orderBy('nom_modiriya')->get();
        $netEtabs  = NetEtab::all();
        return view('etablissements.create', compact('communes', 'modiriyas', 'netEtabs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'NOM_ETAB'               => 'required|string|max:200',
            'type_milieu'            => 'nullable|string|max:50',
            'Nombre_eleves'          => 'nullable|integer|min:0',
            'Disponibilite_logement' => 'nullable|string|max:50',
            'cd_commune'             => 'nullable|exists:commune,CD_COM',
            'modiriya_id'            => 'nullable|exists:modiriya,modiriya_id',
            'CD_NETAB'               => 'nullable|exists:net_etab,CD_NETAB',
        ]);

        Etablisement::create($validated);
        return redirect()->route('etablissements.index')->with('success', 'Établissement créé.');
    }

    public function show(Etablisement $etablisement)
    {
        $etablisement->load(['commune.province.region', 'modiriya', 'netEtab', 'affectations.employer', 'affectations.fonction']);
        return view('etablissements.show', compact('etablisement'));
    }

    public function edit(Etablisement $etablisement)
    {
        $communes  = Commune::orderBy('LIB_COMMUNE_FR')->get();
        $modiriyas = Modiriya::orderBy('nom_modiriya')->get();
        $netEtabs  = NetEtab::all();
        return view('etablissements.create', compact('etablisement', 'communes', 'modiriyas', 'netEtabs'));
    }

    public function update(Request $request, Etablisement $etablisement)
    {
        $validated = $request->validate([
            'NOM_ETAB'               => 'required|string|max:200',
            'type_milieu'            => 'nullable|string|max:50',
            'Nombre_eleves'          => 'nullable|integer|min:0',
            'Disponibilite_logement' => 'nullable|string|max:50',
            'cd_commune'             => 'nullable|exists:commune,CD_COM',
            'modiriya_id'            => 'nullable|exists:modiriya,modiriya_id',
            'CD_NETAB'               => 'nullable|exists:net_etab,CD_NETAB',
        ]);

        $etablisement->update($validated);
        return redirect()->route('etablissements.index')->with('success', 'Établissement mis à jour.');
    }

    public function destroy(Etablisement $etablisement)
    {
        $etablisement->delete();
        return redirect()->route('etablissements.index')->with('success', 'Établissement supprimé.');
    }
}
