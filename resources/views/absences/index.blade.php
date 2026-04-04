@extends('layouts.master')
@section('title','Absences')
@section('page-title','Absences')

@section('main')
<div class="page-header">
  <h1>Gestion des Absences</h1>
  <a href="{{ route('absences.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nouvelle Absence</a>
</div>

<div class="kpi-grid">
  <div class="kpi-card primary">
    <div><div class="kpi-label">Total Absences</div><div class="kpi-value">{{ number_format($totalAbs) }}</div></div>
    <div class="kpi-icon"><i class="fas fa-calendar-times"></i></div>
  </div>
  <div class="kpi-card success">
    <div><div class="kpi-label">Justifiées</div><div class="kpi-value">{{ $justifiees }}</div></div>
    <div class="kpi-icon"><i class="fas fa-check-circle"></i></div>
  </div>
  <div class="kpi-card danger">
    <div><div class="kpi-label">Non Justifiées</div><div class="kpi-value">{{ $nonJustifiees }}</div></div>
    <div class="kpi-icon"><i class="fas fa-times-circle"></i></div>
  </div>
  <div class="kpi-card warning">
    <div><div class="kpi-label">Ce mois</div><div class="kpi-value">{{ $moisCourant }}</div></div>
    <div class="kpi-icon"><i class="fas fa-calendar-alt"></i></div>
  </div>
</div>

{{-- Filtres --}}
<div class="card" style="margin-bottom:20px;">
  <div class="card-body" style="padding:16px;">
    <form method="GET" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
      <div class="form-group" style="margin:0;flex:1;min-width:180px;">
        <label class="form-label">Recherche agent</label>
        <input type="text" name="search" class="form-control" placeholder="Nom, CIN…" value="{{ request('search') }}">
      </div>
      <div class="form-group" style="margin:0;">
        <label class="form-label">Justifiée</label>
        <select name="justify" class="form-control form-select" style="width:140px;">
          <option value="">Toutes</option>
          <option value="1" {{ request('justify')==='1'?'selected':'' }}>Justifiée</option>
          <option value="0" {{ request('justify')==='0'?'selected':'' }}>Non justifiée</option>
        </select>
      </div>
      <div class="form-group" style="margin:0;">
        <label class="form-label">Mois</label>
        <select name="mois" class="form-control form-select" style="width:130px;">
          <option value="">Tous</option>
          @foreach(['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'] as $i=>$m)
            <option value="{{ $i+1 }}" {{ request('mois')==($i+1)?'selected':'' }}>{{ $m }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-primary" style="height:38px;"><i class="fas fa-search"></i> Filtrer</button>
      <a href="{{ route('absences.index') }}" class="btn" style="height:38px;background:#e3e6f0;color:var(--dark);">Réinitialiser</a>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header"><span class="card-title">Liste des Absences</span></div>
  <div class="card-body" style="padding:0;">
    <div class="table-responsive">
      <table>
        <thead>
          <tr><th>#</th><th>Agent</th><th>Type Congé</th><th>Date Début</th><th>Date Fin</th><th>Justifiée</th><th>Certificat</th><th>Actions</th></tr>
        </thead>
        <tbody>
          @forelse($absences as $abs)
          <tr>
            <td><strong>#{{ $abs->id_abs }}</strong></td>
            <td>
              <div style="font-weight:700;">{{ $abs->employer->NOM_PRENOM_FR ?? 'N/A' }}</div>
              <div style="font-size:11px;color:var(--secondary);">{{ $abs->employer->CIN ?? '' }}</div>
            </td>
            <td>{{ $abs->congee->type_congee ?? 'Absence' }}</td>
            <td>{{ $abs->date_debut ? $abs->date_debut->format('d/m/Y') : '-' }}</td>
            <td>{{ $abs->date_fin ? $abs->date_fin->format('d/m/Y') : '-' }}</td>
            <td>
              <span class="badge-pill {{ $abs->is_justify ? 'badge-success' : 'badge-danger' }}">
                {{ $abs->is_justify ? 'Oui' : 'Non' }}
              </span>
            </td>
            <td>
              @if($abs->certificat)
                <a href="{{ Storage::url($abs->certificat) }}" target="_blank" class="btn-sm">
                  <i class="fas fa-file-pdf"></i> Voir
                </a>
              @else
                <span style="color:var(--secondary);">-</span>
              @endif
            </td>
            <td style="white-space:nowrap;">
              <a href="{{ route('absences.edit', $abs) }}" class="btn-sm"><i class="fas fa-edit"></i></a>
              <form action="{{ route('absences.destroy', $abs) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm" style="color:var(--danger);"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="8" style="text-align:center;padding:30px;color:var(--secondary);">Aucune absence trouvée</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="pagination-wrap">
      <span style="font-size:12px;color:var(--secondary);">{{ $absences->firstItem() }}-{{ $absences->lastItem() }} sur {{ $absences->total() }}</span>
      {{ $absences->links() }}
    </div>
  </div>
</div>
@endsection