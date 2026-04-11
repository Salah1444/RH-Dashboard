@extends('layouts.master')

@section('title', 'Communes')

@section('breadcrumb')
    <li class="breadcrumb-item active">Communes</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-city mr-2 text-primary"></i>Communes
    </h1>
    <a href="{{ route('communes.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm mr-1"></i> Nouvelle commune
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Liste des communes
            <span class="badge badge-light ml-1">{{ $communes->total() }}</span>
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Nom (FR)</th>
                        <th>Milieu</th>
                        <th>Province</th>
                        <th>Région</th>
                        <th class="text-center">Étab.</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($communes as $commune)
                        <tr>
                            <td class="text-muted small">{{ $commune->CD_COM }}</td>
                            <td>
                                <div class="font-weight-bold">{{ $commune->LIB_COMMUNE_FR }}</div>
                                @if($commune->LIB_COMMUNE_AR)
                                    <small class="text-muted" dir="rtl">{{ $commune->LIB_COMMUNE_AR }}</small>
                                @endif
                            </td>
                            <td>
                                @if($commune->LIB_MILIEU_FR)
                                    <span class="badge badge-{{ $commune->LIB_MILIEU_FR === 'Urbain' ? 'primary' : 'success' }}">
                                        {{ $commune->LIB_MILIEU_FR }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $commune->province->LIB_PROVINCE_FR ?? '—' }}</td>
                            <td>
                                <span class="badge badge-light text-dark">
                                    {{ $commune->province->region->LIB_REGION_FR ?? '—' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ $commune->etablissements_count }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('communes.show', $commune->CD_COM) }}"
                                   class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('communes.edit', $commune->CD_COM) }}"
                                   class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('communes.destroy', $commune->CD_COM) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Supprimer cette commune ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>Aucune commune.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($communes->hasPages())
        <div class="card-footer bg-white">{{ $communes->links() }}</div>
    @endif
</div>
@endsection
