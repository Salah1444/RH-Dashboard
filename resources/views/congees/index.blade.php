@extends('layouts.master')
@section('title','Congés')
@section('page-title','Gestion des Congés')

@section('content')
<div class="page-header">
  <h1>Types de Congés</h1>
  <a href="{{ route('congees.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nouveau Congé</a>
</div>

<div class="card">
  <div class="card-header"><span class="card-title">Liste des congés</span></div>
  <div class="card-body" style="padding:0;">
    <div class="table-responsive">
      <table>
        <thead>
          <tr><th>#</th><th>Type de Congé</th><th>Date Début</th><th>Date Fin</th><th>Nombre de Jours</th><th>Absences liées</th><th>Actions</th></tr>
        </thead>
        <tbody>
          @forelse($congees as $cg)
          <tr>
            <td><strong>#{{ $cg->id_congee }}</strong></td>
            <td style="font-weight:700;">{{ $cg->type_congee }}</td>
            <td>{{ $cg->date_debut ? \Carbon\Carbon::parse($cg->date_debut)->format('d/m/Y') : '-' }}</td>
            <td>{{ $cg->date_fin ? \Carbon\Carbon::parse($cg->date_fin)->format('d/m/Y') : '-' }}</td>
            <td><span class="badge-pill badge-info">{{ $cg->nombre_jrs ?? '-' }} jrs</span></td>
            <td>{{ $cg->absences_count ?? 0 }}</td>
            <td style="white-space:nowrap;">
              <a href="{{ route('congees.edit', $cg) }}" class="btn-sm"><i class="fas fa-edit"></i></a>
              <form action="{{ route('congees.destroy', $cg) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm" style="color:var(--danger);"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" style="text-align:center;padding:30px;color:var(--secondary);">Aucun congé enregistré</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="pagination-wrap">
      <span style="font-size:12px;color:var(--secondary);">{{ $congees->total() }} congés au total</span>
      {{ $congees->links() }}
    </div>
  </div>
</div>
@endsection
