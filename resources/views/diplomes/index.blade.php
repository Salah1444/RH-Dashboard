@extends('layouts.master')
@section('title','Diplômes')
@section('page-title','Diplômes')

@section('content')
<div class="page-header">
  <h1>Gestion des Diplômes</h1>
  <a href="{{ route('diplomes.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Ajouter un Diplôme</a>
</div>

<!-- Import Excel -->
<x-excel-import
  :import-route="route('diplomes.import')"
  :template-route="route('diplomes.template')"
  label="diplômes"
/>

<div class="kpi-grid">
  <div class="kpi-card primary">
    <div><div class="kpi-label">Total Diplômes</div><div class="kpi-value">{{ number_format($totalDip) }}</div></div>
    <div class="kpi-icon"><i class="fas fa-graduation-cap"></i></div>
  </div>
  <div class="kpi-card info">
    <div><div class="kpi-label">Scolaires</div><div class="kpi-value">{{ $scolaires }}</div></div>
    <div class="kpi-icon"><i class="fas fa-book"></i></div>
  </div>
  <div class="kpi-card success">
    <div><div class="kpi-label">Professionnels</div><div class="kpi-value">{{ $pro }}</div></div>
    <div class="kpi-icon"><i class="fas fa-briefcase"></i></div>
  </div>
  <div class="kpi-card warning">
    <div><div class="kpi-label">Avec PDF</div><div class="kpi-value">{{ $avecPDF }}</div></div>
    <div class="kpi-icon"><i class="fas fa-file-pdf"></i></div>
  </div>
</div>

{{-- Filtres --}}
<div class="card" style="margin-bottom:20px;">
  <div class="card-body" style="padding:16px;">
    <form method="GET" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
      <div class="form-group" style="margin:0;flex:1;min-width:200px;">
        <label class="form-label">Recherche</label>
        <input type="text" name="search" class="form-control" placeholder="Diplôme ou nom de l'agent…" value="{{ request('search') }}">
      </div>
      <div class="form-group" style="margin:0;">
        <label class="form-label">Type</label>
        <select name="type" class="form-control form-select" style="width:150px;">
          <option value="">Tous</option>
          <option value="SCOLAIRE" {{ request('type')=='SCOLAIRE'?'selected':'' }}>Scolaire</option>
          <option value="PRO"      {{ request('type')=='PRO'?'selected':'' }}>Professionnel</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary" style="height:38px;"><i class="fas fa-search"></i> Filtrer</button>
      <a href="{{ route('diplomes.index') }}" class="btn" style="height:38px;background:#e3e6f0;color:var(--dark);">Réinitialiser</a>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header"><span class="card-title">Liste des Diplômes</span></div>
  <div class="card-body" style="padding:0;">
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>#</th><th>Agent</th><th>Intitulé du Diplôme</th><th>Type</th>
            <th>Établissement</th><th>Date</th><th>Mention</th><th>PDF</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($diplomes as $dip)
          <tr>
            <td><strong>#{{ $dip->CD_DIP }}</strong></td>
            <td>
              <a href="{{ route('employes.show', $dip->employer) }}" style="font-weight:700;color:var(--primary);text-decoration:none;">
                {{ $dip->employer->NOM_PRENOM_FR ?? 'N/A' }}
              </a>
              <div style="font-size:11px;color:var(--secondary);">{{ $dip->employer->CIN ?? '' }}</div>
            </td>
            <td style="font-weight:600;">{{ $dip->LL_DIP }}</td>
            <td>
              <span class="badge-pill {{ $dip->TYPE_DIP=='SCOLAIRE' ? 'badge-info' : 'badge-success' }}">
                {{ $dip->TYPE_DIP }}
              </span>
            </td>
            <td>{{ $dip->etablissement_formation ?? '-' }}</td>
            <td>{{ $dip->DT_DIP ? \Carbon\Carbon::parse($dip->DT_DIP)->format('d/m/Y') : '-' }}</td>
            <td>
              @if($dip->montion)
                <span class="badge-pill badge-warning">{{ $dip->montion }}/20</span>
              @else
                <span style="color:var(--secondary);">-</span>
              @endif
            </td>
            <td>
              @if($dip->PDF)
                <a href="{{ Storage::url($dip->PDF) }}" target="_blank" class="btn-sm" style="color:var(--danger);">
                  <i class="fas fa-file-pdf"></i> Voir
                </a>
              @else
                <span style="color:var(--secondary);">-</span>
              @endif
            </td>
            
            <td style="white-space:nowrap;">
              <a href="{{ route('diplomes.edit', $dip->CD_DIP) }}" class="btn-sm"><i class="fas fa-edit"></i></a>
              <form action="{{ route('diplomes.destroy', $dip) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ce diplôme ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm" style="color:var(--danger);"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="9" style="text-align:center;padding:30px;color:var(--secondary);">
              <i class="fas fa-graduation-cap" style="font-size:24px;display:block;margin-bottom:8px;opacity:.3;"></i>
              Aucun diplôme trouvé
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="pagination-wrap">
      <span style="font-size:12px;color:var(--secondary);">
        Affichage {{ $diplomes->firstItem() }}-{{ $diplomes->lastItem() }} sur {{ $diplomes->total() }}
      </span>
      {{ $diplomes->links() }}
    </div>
  </div>
</div>
@endsection
