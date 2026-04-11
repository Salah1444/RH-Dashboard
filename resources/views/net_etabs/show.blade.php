@extends('layouts.master')

@section('title', $netEtab->LIBELLE_net_etab)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('net_etabs.index') }}">Réseaux</a></li>
    <li class="breadcrumb-item active">{{ $netEtab->LIBELLE_net_etab }}</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-network-wired mr-2 text-primary"></i>{{ $netEtab->LIBELLE_net_etab }}
    </h1>
    <div>
        <a href="{{ route('net_etabs.edit', $netEtab->CD_NETAB) }}" class="btn btn-warning btn-sm mr-2">
            <i class="fas fa-edit mr-1"></i>Modifier
        </a>
        <a href="{{ route('net_etabs.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i>Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Détails</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted small">Code</td>
                        <td class="font-weight-bold">{{ $netEtab->CD_NETAB }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Libellé</td>
                        <td>{{ $netEtab->LIBELLE_net_etab }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Établissements</td>
                        <td><span class="badge badge-info">{{ $netEtab->etablissements->count() }}</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Établissements du réseau</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Établissement</th>
                            <th>Commune</th>
                            <th>Province</th>
                            <th>Région</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($netEtab->etablissements as $etab)
                            <tr>
                                <td>{{ $etab->nom ?? $etab->NOM_ETAB ?? '—' }}</td>
                                <td>{{ $etab->commune->LIB_COMMUNE_FR ?? '—' }}</td>
                                <td>{{ $etab->commune->province->LIB_PROVINCE_FR ?? '—' }}</td>
                                <td>{{ $etab->commune->province->region->LIB_REGION_FR ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    Aucun établissement dans ce réseau.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
