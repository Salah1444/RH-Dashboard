@extends('layouts.master')

@section('title', 'Provinces')

@section('breadcrumb')
    <li class="breadcrumb-item active">Provinces</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-map mr-2 text-primary"></i>Provinces
    </h1>
    <a href="{{ route('provinces.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm mr-1"></i> Nouvelle province
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Liste des provinces
            <span class="badge badge-light ml-1">{{ $provinces->total() }}</span>
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
                        <th>Région</th>
                        <th class="text-center">Communes</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($provinces as $province)
                        <tr>
                            <td class="text-muted small">{{ $province->CD_PRV }}</td>
                            <td class="font-weight-bold">{{ $province->LIB_PROVINCE_FR }}</td>
                            <td dir="rtl" class="text-right">{{ $province->LIB_PROVINCE_AR }}</td>
                            <td>
                                @if ($province->region)
                                    <a href="{{ route('regions.show', $province->region->CD_REG) }}"
                                       class="badge badge-primary">
                                        {{ $province->region->LIB_REGION_FR }}
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ $province->communes_count }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('provinces.show', $province->CD_PRV) }}"
                                   class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('provinces.edit', $province->CD_PRV) }}"
                                   class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('provinces.destroy', $province->CD_PRV) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Supprimer cette province ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Aucune province enregistrée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($provinces->hasPages())
        <div class="card-footer bg-white">{{ $provinces->links() }}</div>
    @endif
</div>
@endsection
