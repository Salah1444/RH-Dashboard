@extends('layouts.master')
@section('title', 'Gestion des Affectations')
@section('page-title', 'Gestion des Affectations')

@section('content')
<div class="page-header">
  <h1>Gestion des Affectations</h1>
  <a href="{{ route('affectations.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Nouvelle Affectation
  </a>
</div>


<!-- Import Excel -->
<x-excel-import
  :import-route="route('affectations.import')"
  :template-route="route('affectations.template')"
  label="affectations"
/>

<!-- KPIs -->
<div class="kpi-grid">
  <div class="kpi-card primary">
    <div><div class="kpi-label">Total Affectations</div><div class="kpi-value">{{ number_format($totalAff) }}</div></div>
    <div class="kpi-icon"><i class="fas fa-map-pin"></i></div>
  </div>
  <div class="kpi-card success">
    <div><div class="kpi-label">Mutations</div><div class="kpi-value">{{ $mutations }}</div></div>
    <div class="kpi-icon"><i class="fas fa-exchange-alt"></i></div>
  </div>
  <div class="kpi-card info">
    <div><div class="kpi-label">Détachements</div><div class="kpi-value">{{ $detachements }}</div></div>
    <div class="kpi-icon"><i class="fas fa-link"></i></div>
  </div>
  <div class="kpi-card warning">
    <div><div class="kpi-label">Intérims</div><div class="kpi-value">{{ $interims }}</div></div>
    <div class="kpi-icon"><i class="fas fa-user-clock"></i></div>
  </div>
</div>

<!-- Filtres -->
<div class="card" style="margin-bottom:20px;">
  <div class="card-body" style="padding:16px;">
    <form method="GET" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
      <div class="form-group" style="margin:0;flex:1;min-width:200px;">
        <label class="form-label">Recherche agent</label>
        <input type="text" name="search" class="form-control" placeholder="Nom, CIN…" value="{{ request('search') }}">
      </div>
      <div class="form-group" style="margin:0;">
        <label class="form-label">Mode</label>
        <select name="mode" class="form-control form-select" style="width:160px;">
          <option value="">Tous</option>
          @foreach($modes as $mode)
            <option value="{{ $mode }}" {{ request('mode')==$mode?'selected':'' }}>{{ $mode }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group" style="margin:0;">
        <label class="form-label">Établissement</label>
        <select name="etab" class="form-control form-select" style="width:200px;">
          <option value="">Tous</option>
          @foreach($etablissements as $etab)
            <option value="{{ $etab->CD_ETAB }}" {{ request('etab')==$etab->CD_ETAB?'selected':'' }}>{{ $etab->NOM_ETAB }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-primary" style="height:38px;"><i class="fas fa-search"></i> Filtrer</button>
      <a href="{{ route('affectations.index') }}" class="btn" style="height:38px;background:#e3e6f0;color:var(--dark);">Réinitialiser</a>
    </form>
  </div>
</div>

<!-- Table -->
<div class="card">
  <div class="card-header"><span class="card-title">Tableau des Affectations</span></div>
  <div class="card-body" style="padding:0;">
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>#</th><th>Agent</th><th>Établissement</th><th>Fonction</th>
            <th>Date Poste</th><th>Date Début</th><th>Mode</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($affectations as $aff)
          <tr>
            <td><strong>#{{ $aff->id_aff }}</strong></td>
            <td>
              <div style="font-weight:700;">{{ $aff->employer->NOM_PRENOM_FR ?? 'N/A' }}</div>
              <div style="font-size:11px;color:var(--secondary);">{{ $aff->employer->CIN ?? '' }}</div>
            </td>
            <td>{{ $aff->etablisement->NOM_ETAB ?? '-' }}</td>
            <td>{{ $aff->fonction->LIB_FONCTION_FR ?? '-' }}</td>
            <td>{{ $aff->DT_AFF_POSTE ? $aff->DT_AFF_POSTE->format('d/m/Y') : '-' }}</td>
            <td>{{ $aff->DATE_DEBUT_AFF ? $aff->DATE_DEBUT_AFF->format('d/m/Y') : '-' }}</td>
            <td>
              @php
                $badgeMap = ['Mutation'=>'badge-primary','Nouveau'=>'badge-success','Détachement'=>'badge-info','Intérim'=>'badge-warning'];
                $badge = $badgeMap[$aff->Mode_Affectation] ?? 'badge-secondary';
              @endphp
              <span class="badge-pill {{ $badge }}">{{ $aff->Mode_Affectation ?? '-' }}</span>
            </td>
            <td style="white-space:nowrap;">
              <a href="{{ route('affectations.edit', $aff) }}" class="btn-sm"><i class="fas fa-edit"></i></a>
              <form action="{{ route('affectations.destroy', $aff) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm" style="color:var(--danger);"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="8" style="text-align:center;padding:30px;color:var(--secondary);">Aucune affectation trouvée</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="pagination-wrap">
      <span style="font-size:12px;color:var(--secondary);">
        Affichage {{ $affectations->firstItem() }}-{{ $affectations->lastItem() }} sur {{ $affectations->total() }}
      </span>
      {{ $affectations->links() }}
    </div>
  </div>
</div>
@endsection
