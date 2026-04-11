@extends('layouts.master')

@section('title', "Réseaux d'établissements")

@section('breadcrumb')
    <li class="breadcrumb-item active">Réseaux d'établissements</li>
@endsection

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-network-wired mr-2 text-primary"></i>Réseaux d'établissements
    </h1>
    <a href="{{ route('net_etabs.create') }}" class="btn btn-primary btn-sm shadow-sm">
        <i class="fas fa-plus fa-sm mr-1"></i> Nouveau réseau
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Liste des réseaux
            <span class="badge badge-light ml-1">{{ $netEtabs->total() }}</span>
        </h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Libellé</th>
                        <th class="text-center">Établissements</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($netEtabs as $net)
                        <tr>
                            <td class="text-muted small">{{ $net->CD_NETAB }}</td>
                            <td class="font-weight-bold">{{ $net->LIBELLE_net_etab }}</td>
                            <td class="text-center">
                                <span class="badge badge-info">{{ $net->etablissements_count }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('net_etabs.show', $net->CD_NETAB) }}"
                                   class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('net_etabs.edit', $net->CD_NETAB) }}"
                                   class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('net_etabs.destroy', $net->CD_NETAB) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Supprimer ce réseau ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>Aucun réseau.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($netEtabs->hasPages())
        <div class="card-footer bg-white">{{ $netEtabs->links() }}</div>
    @endif
</div>
@endsection
