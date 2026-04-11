@extends('layouts.master')

@section('title', 'Modiriyas')

@section('breadcrumb')
    <li class="breadcrumb-item active">Modiriyas</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-building mr-2 text-primary"></i>Modiriyas (Délégations)
    </h1>
    <a href="{{ route('modiriyas.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm mr-1"></i> Nouvelle modiriya
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Liste des modiriyas
            <span class="badge badge-light ml-1">{{ $modiriyas->total() }}</span>
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Région</th>
                        <th class="text-center">Établissements</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($modiriyas as $mod)
                        <tr>
                            <td class="text-muted small">{{ $mod->modiriya_id }}</td>
                            <td class="font-weight-bold">{{ $mod->nom_modiriya }}</td>
                            <td>
                                @if($mod->region)
                                    <span class="badge badge-primary">{{ $mod->region->LIB_REGION_FR }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ $mod->etablissements_count }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('modiriyas.show', $mod->modiriya_id) }}"
                                   class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('modiriyas.edit', $mod->modiriya_id) }}"
                                   class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('modiriyas.destroy', $mod->modiriya_id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Supprimer cette modiriya ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>Aucune modiriya.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($modiriyas->hasPages())
        <div class="card-footer bg-white">{{ $modiriyas->links() }}</div>
    @endif
</div>
@endsection
