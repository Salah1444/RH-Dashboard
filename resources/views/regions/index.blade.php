@extends('layouts.master')

@section('title', 'Régions')

@section('breadcrumb')
    <li class="breadcrumb-item active">Régions</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-globe-africa mr-2 text-primary"></i>Régions
    </h1>
    <a href="{{ route('regions.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm mr-1"></i> Nouvelle région
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            Liste des régions
            <span class="badge badge-light ml-1">{{ $regions->total() }}</span>
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Nom (FR)</th>
                        <th>الاسم (AR)</th>
                        <th class="text-center">Provinces</th>
                        <th class="text-center">Modiriyas</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($regions as $region)
                        <tr>
                            <td class="text-muted small">{{ $region->CD_REG }}</td>
                            <td class="font-weight-bold">{{ $region->LIB_REGION_FR }}</td>
                            <td class="text-right" dir="rtl">{{ $region->LIB_REGION_AR }}</td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ $region->provinces_count }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-secondary">{{ $region->modiriyas_count }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('regions.show', $region->CD_REG) }}"
                                   class="btn btn-sm btn-info" title="Détail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('regions.edit', $region->CD_REG) }}"
                                   class="btn btn-sm btn-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('regions.destroy', $region->CD_REG) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Supprimer cette région ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Aucune région enregistrée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($regions->hasPages())
        <div class="card-footer bg-white">
            {{ $regions->links() }}
        </div>
    @endif
</div>
@endsection
