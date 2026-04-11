@extends('layouts.master')

@section('title', $province->LIB_PROVINCE_FR)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('provinces.index') }}">Provinces</a></li>
    <li class="breadcrumb-item active">{{ $province->LIB_PROVINCE_FR }}</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-map mr-2 text-primary"></i>{{ $province->LIB_PROVINCE_FR }}
    </h1>
    <div>
        <a href="{{ route('provinces.edit', $province->CD_PRV) }}" class="btn btn-warning btn-sm mr-2">
            <i class="fas fa-edit mr-1"></i>Modifier
        </a>
        <a href="{{ route('provinces.index') }}" class="btn btn-secondary btn-sm">
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
                        <td class="font-weight-bold">{{ $province->CD_PRV }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Nom (FR)</td>
                        <td>{{ $province->LIB_PROVINCE_FR }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">الاسم</td>
                        <td dir="rtl" class="text-right">{{ $province->LIB_PROVINCE_AR ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Région</td>
                        <td>
                            @if($province->region)
                                <a href="{{ route('regions.show', $province->region->CD_REG) }}"
                                   class="badge badge-primary">
                                    {{ $province->region->LIB_REGION_FR }}
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Communes</td>
                        <td><span class="badge badge-info">{{ $province->communes->count() }}</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Communes</h6>
                <a href="{{ route('communes.create') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-plus fa-xs mr-1"></i>Ajouter
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nom (FR)</th>
                            <th>Milieu</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($province->communes as $commune)
                            <tr>
                                <td>{{ $commune->LIB_COMMUNE_FR }}</td>
                                <td>
                                    @if($commune->LIB_MILIEU_FR)
                                        <span class="badge badge-{{ $commune->LIB_MILIEU_FR === 'Urbain' ? 'primary' : 'success' }}">
                                            {{ $commune->LIB_MILIEU_FR }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('communes.show', $commune->CD_COM) }}"
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye fa-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">Aucune commune.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
