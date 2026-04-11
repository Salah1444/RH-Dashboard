@extends('layouts.master')

@section('title', $modiriya->nom_modiriya)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('modiriyas.index') }}">Modiriyas</a></li>
    <li class="breadcrumb-item active">{{ $modiriya->nom_modiriya }}</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-building mr-2 text-primary"></i>{{ $modiriya->nom_modiriya }}
    </h1>
    <div>
        <a href="{{ route('modiriyas.edit', $modiriya->modiriya_id) }}" class="btn btn-warning btn-sm mr-2">
            <i class="fas fa-edit mr-1"></i>Modifier
        </a>
        <a href="{{ route('modiriyas.index') }}" class="btn btn-secondary btn-sm">
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
                        <td class="text-muted small">ID</td>
                        <td class="font-weight-bold">{{ $modiriya->modiriya_id }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Nom</td>
                        <td>{{ $modiriya->nom_modiriya }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Région</td>
                        <td>
                            @if($modiriya->region)
                                <a href="{{ route('regions.show', $modiriya->region->CD_REG) }}"
                                   class="badge badge-primary">
                                    {{ $modiriya->region->LIB_REGION_FR }}
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Établissements</td>
                        <td><span class="badge badge-info">{{ $modiriya->etablissements->count() }}</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Établissements rattachés</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Établissement</th>
                            <th>Commune</th>
                            <th>Province</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($modiriya->etablissements as $etab)
                            <tr>
                                <td>{{ $etab->nom ?? $etab->LIBELLE ?? '—' }}</td>
                                <td>{{ $etab->commune->LIB_COMMUNE_FR ?? '—' }}</td>
                                <td>{{ $etab->commune->province->LIB_PROVINCE_FR ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    Aucun établissement.
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
