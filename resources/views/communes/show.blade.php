@extends('layouts.master')

@section('title', $commune->LIB_COMMUNE_FR)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('communes.index') }}">Communes</a></li>
    <li class="breadcrumb-item active">{{ $commune->LIB_COMMUNE_FR }}</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-city mr-2 text-primary"></i>{{ $commune->LIB_COMMUNE_FR }}
    </h1>
    <div>
        <a href="{{ route('communes.edit', $commune->CD_COM) }}" class="btn btn-warning btn-sm mr-2">
            <i class="fas fa-edit mr-1"></i>Modifier
        </a>
        <a href="{{ route('communes.index') }}" class="btn btn-secondary btn-sm">
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
                        <td class="font-weight-bold">{{ $commune->CD_COM }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Nom (FR)</td>
                        <td>{{ $commune->LIB_COMMUNE_FR }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">الاسم</td>
                        <td dir="rtl" class="text-right">{{ $commune->LIB_COMMUNE_AR ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Milieu</td>
                        <td>
                            @if($commune->LIB_MILIEU_FR)
                                <span class="badge badge-{{ $commune->LIB_MILIEU_FR === 'Urbain' ? 'primary' : 'success' }}">
                                    {{ $commune->LIB_MILIEU_FR }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Province</td>
                        <td>
                            @if($commune->province)
                                <a href="{{ route('provinces.show', $commune->province->CD_PRV) }}"
                                   class="badge badge-info">
                                    {{ $commune->province->LIB_PROVINCE_FR }}
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Région</td>
                        <td>
                            @if($commune->province?->region)
                                <span class="badge badge-primary">
                                    {{ $commune->province->region->LIB_REGION_FR }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Établissements</h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($commune->etablissements as $etab)
                            <tr>
                                <td class="text-muted small">{{ $etab->getKey() }}</td>
                                <td>{{ $etab->nom ?? $etab->NOM_ETAB ?? '—' }}</td>
                                <td class="text-right">
                                    {{-- Link to établissement show if route exists --}}
                                </td>
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
