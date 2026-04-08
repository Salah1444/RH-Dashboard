@extends('layouts.master')
@section('title','Établissements')
@section('page-title','Établissements')

@section('content')
<div class="page-header">
  <h1>Gestion des Établissements</h1>
  <a href="{{ route('etablissements.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nouvel Établissement</a>
</div>

<div class="kpi-grid">
  <div class="kpi-card primary">
    <div><div class="kpi-label">Total</div><div class="kpi-value">{{ $totalEtab }}</div></div>
    <div class="kpi-icon"><i class="fas fa-school"></i></div>
  </div>
  <div class="kpi-card info">
    <div><div class="kpi-label">Urbain</div><div class="kpi-value">{{ $urbains }}</div></div>
    <div class="kpi-icon"><i class="fas fa-city"></i></div>
  </div>
  <div class="kpi-card success">
    <div><div class="kpi-label">Rural</div><div class="kpi-value">{{ $ruraux }}</div></div>
    <div class="kpi-icon"><i class="fas fa-tree"></i></div>
  </div>
  <div class="kpi-card warning">
    <div><div class="kpi-label">Avec logement</div><div class="kpi-value">{{ $avecLogement }}</div></div>
    <div class="kpi-icon"><i class="fas fa-home"></i></div>
  </div>
</div>

{{-- Filtres --}}
<div class="card" style="margin-bottom:20px;">
  <div class="card-body" style="padding:16px;">
    <form method="GET" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
      <div class="form-group" style="margin:0;flex:1;min-width:200px;">
        <label class="form-label">Recherche</label>
        <input type="text" name="search" class="form-control" placeholder="Nom de l'établissement…" value="{{ request('search') }}">
      </div>
      <div class="form-group" style="margin:0;">
        <label class="form-label">Milieu</label>
        <select name="milieu" class="form-control form-select" style="width:130px;">
          <option value="">Tous</option>
          <option value="Urbain" {{ request('milieu')=='Urbain'?'selected':'' }}>Urbain</option>
          <option value="Rural"  {{ request('milieu')=='Rural'?'selected':'' }}>Rural</option>
        </select>
      </div>
      <div class="form-group" style="margin:0;">
        <label class="form-label">Modiriya</label>
        <select name="modiriya" class="form-control form-select" style="width:180px;">
          <option value="">Toutes</option>
          @foreach($modiriyas as $mod)
            <option value="{{ $mod->modiriya_id }}" {{ request('modiriya')==$mod->modiriya_id?'selected':'' }}>{{ $mod->nom_modiriya }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-primary" style="height:38px;"><i class="fas fa-search"></i> Filtrer</button>
      <a href="{{ route('etablissements.index') }}" class="btn" style="height:38px;background:#e3e6f0;color:var(--dark);">Réinitialiser</a>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header"><span class="card-title">Liste des Établissements</span></div>
  <div class="card-body" style="padding:0;">
    <div class="table-responsive">
      <table>
        <thead>
          <tr><th>#</th><th>Nom de l'Établissement</th><th>Milieu</th><th>Commune</th><th>Modiriya</th><th>Réseau</th><th>Élèves</th><th>Logement</th><th>Actions</th></tr>
        </thead>
        <tbody>
          @forelse($etablissements as $etab)
          <tr>
            <td><strong>#{{ $etab->CD_ETAB }}</strong></td>
            <td style="font-weight:700;">{{ $etab->NOM_ETAB }}</td>
            <td><span class="badge-pill {{ $etab->type_milieu=='Urbain'?'badge-info':'badge-success' }}">{{ $etab->type_milieu ?? '-' }}</span></td>
            <td>{{ $etab->commune->LIB_COMMUNE_FR ?? '-' }}</td>
            <td>{{ $etab->modiriya->nom_modiriya ?? '-' }}</td>
            <td>{{ $etab->netEtab->LIBELLE_net_etab ?? '-' }}</td>
            <td>{{ $etab->Nombre_eleves ?? '-' }}</td>
            <td>
              @if($etab->Disponibilite_logement === 'Oui')
                <span class="badge-pill badge-success"><i class="fas fa-check"></i> Oui</span>
              @else
                <span class="badge-pill badge-secondary">Non</span>
              @endif
            </td>
            <td style="white-space:nowrap;">
              <a href="{{ route('etablissements.show', $etab->CD_ETAB) }}" class="btn-sm"><i class="fas fa-eye"></i></a>
              <a href="{{ route('etablissements.edit', $etab->CD_ETAB) }}" class="btn-sm"><i class="fas fa-edit"></i></a>
              <form action="{{ route('etablissements.destroy', $etab) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm" style="color:var(--danger);"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="9" style="text-align:center;padding:30px;color:var(--secondary);">Aucun établissement trouvé</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="pagination-wrap">
      <span style="font-size:12px;color:var(--secondary);">{{ $etablissements->firstItem() }}-{{ $etablissements->lastItem() }} sur {{ $etablissements->total() }}</span>
      {{ $etablissements->links() }}
    </div>
  </div>
</div>
@endsection
