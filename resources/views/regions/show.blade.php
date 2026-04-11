@extends('layouts.master')

@section('title', $region->LIB_REGION_FR)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('regions.index') }}">Régions</a></li>
    <li class="breadcrumb-item active">{{ $region->LIB_REGION_FR }}</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-globe-africa mr-2 text-primary"></i>{{ $region->LIB_REGION_FR }}
    </h1>
    <div>
        <a href="{{ route('regions.edit', $region->CD_REG) }}" class="btn btn-warning btn-sm mr-2">
            <i class="fas fa-edit mr-1"></i>Modifier
        </a>
        <a href="{{ route('regions.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i>Retour
        </a>
    </div>
</div>

<div class="row">
    {{-- Info card --}}
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Détails</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted small">Code</td>
                        <td class="font-weight-bold">{{ $region->CD_REG }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Nom (FR)</td>
                        <td>{{ $region->LIB_REGION_FR }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">الاسم</td>
                        <td dir="rtl" class="text-right">{{ $region->LIB_REGION_AR ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Provinces</td>
                        <td><span class="badge badge-info">{{ $region->provinces->count() }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted small">Modiriyas</td>
                        <td><span class="badge badge-secondary">{{ $region->modiriyas->count() }}</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Provinces --}}
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Provinces</h6>
                <a href="{{ route('provinces.create') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-plus fa-xs mr-1"></i>Ajouter
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nom (FR)</th>
                            <th>الاسم</th>
                            <th class="text-center">Communes</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($region->provinces as $province)
                            <tr>
                                <td>{{ $province->LIB_PROVINCE_FR }}</td>
                                <td dir="rtl" class="text-right small">{{ $province->LIB_PROVINCE_AR }}</td>
                                <td class="text-center">
                                    <span class="badge badge-info">{{ $province->communes->count() }}</span>
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('provinces.show', $province->CD_PRV) }}"
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye fa-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    Aucune province.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modiriyas --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Modiriyas</h6>
                <a href="{{ route('modiriyas.create') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-plus fa-xs mr-1"></i>Ajouter
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-hover mb-0">
                    <thead class="thead-light">
                        <tr><th>Nom</th><th></th></tr>
                    </thead>
                    <tbody>
                        @forelse ($region->modiriyas as $mod)
                            <tr>
                                <td>{{ $mod->nom_modiriya }}</td>
                                <td class="text-right">
                                    <a href="{{ route('modiriyas.show', $mod->modiriya_id) }}"
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye fa-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-3">Aucune modiriya.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
