@extends('layouts.master')
@section('title', 'Gestion des Employés')
@section('page-title', 'Gestion des Employés')

@section('content')
<div class="page-header">
  <h1>Gestion des Employés</h1>
  <a href="{{ route('employes.create') }}" class="btn btn-primary">
    <i class="fas fa-plus"></i> Nouvel Employé
  </a>
</div>

<!-- KPIs -->
<div class="kpi-grid" style="grid-template-columns:repeat(3,1fr);">
  <div class="kpi-card primary">
    <div><div class="kpi-label">Effectif Total</div><div class="kpi-value">{{ number_format($total) }}</div></div>
    <div class="kpi-icon"><i class="fas fa-users"></i></div>
  </div>
  <div class="kpi-card success">
    <div><div class="kpi-label">Hommes</div><div class="kpi-value">{{ $hommes }}</div></div>
    <div class="kpi-icon"><i class="fas fa-male"></i></div>
  </div>
  <div class="kpi-card danger">
    <div><div class="kpi-label">Femmes</div><div class="kpi-value">{{ $femmes }}</div></div>
    <div class="kpi-icon"><i class="fas fa-female"></i></div>
  </div>
</div>

<!-- Filtres -->
<div class="card" style="margin-bottom:20px;">
  <div class="card-body" style="padding:16px;">
    <form method="GET" action="{{ route('employes.index') }}" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
      <div class="form-group" style="margin:0;flex:1;min-width:200px;">
        <label class="form-label">Recherche</label>
        <input type="text" name="search" class="form-control" placeholder="Nom, CIN, Code Agent…" value="{{ request('search') }}">
      </div>
      <div class="form-group" style="margin:0;">
        <label class="form-label">Sexe</label>
        <select name="sexe" class="form-control form-select" style="width:120px;">
          <option value="">Tous</option>
          <option value="M" {{ request('sexe')=='M'?'selected':'' }}>Homme</option>
          <option value="F" {{ request('sexe')=='F'?'selected':'' }}>Femme</option>
        </select>
      </div>
      <div class="form-group" style="margin:0;">
        <label class="form-label">Position</label>
        <select name="position_id" class="form-control form-select" style="width:160px;">
          <option value="">Toutes</option>
          @foreach($positions as $pos)
            <option value="{{ $pos->COD_POS }}" {{ request('position_id')==$pos->COD_POS?'selected':'' }}>
              {{ $pos->LIB_POSITION_FR }}
            </option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-primary" style="height:38px;">
        <i class="fas fa-search"></i> Filtrer
      </button>
      <a href="{{ route('employes.index') }}" class="btn" style="height:38px;background:#e3e6f0;color:var(--dark);">
        <i class="fas fa-times"></i> Réinitialiser
      </a>
    </form>
  </div>
</div>

<!-- Table -->
<div class="card">
  <div class="card-header">
    <span class="card-title">Liste des Employés</span>
    <div style="display:flex;gap:8px;">
      <button class="btn-sm"><i class="fas fa-download"></i> Export</button>
    </div>
  </div>
  <div class="card-body" style="padding:0;">
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>#</th><th>Nom & Prénom</th><th>CIN</th><th>Sexe</th>
            <th>Date Naiss.</th><th>Sit. Familiale</th><th>Tél. Portable</th>
            <th>Position</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($employes as $emp)
          @php
            $colors = ['#4e73df','#e74a3b','#1cc88a','#f6c23e','#858796','#36b9cc'];
            $c = $colors[$loop->index % count($colors)];
            $initiales = strtoupper(substr($emp->NOM_PRENOM_FR ?? '?', 0, 2));
          @endphp
          <tr>
            <td><strong>#{{ $emp->COD_AG }}</strong></td>
            <td>
              <div style="display:flex;align-items:center;">
                @if($emp->photo && $emp->photo !== 'default.png')
                  <img src="{{ Storage::url($emp->photo) }}" style="width:30px;height:30px;border-radius:50%;object-fit:cover;margin-right:8px;">
                @else
                  <div class="avatar-sm" style="background:{{ $c }};">{{ $initiales }}</div>
                @endif
                <div>
                  <div style="font-weight:700;">{{ $emp->NOM_PRENOM_FR }}</div>
                  <div style="font-size:11px;color:var(--secondary);">{{ $emp->ADRESSE_ELEC ?? '' }}</div>
                </div>
              </div>
            </td>
            <td>{{ $emp->CIN ?? '-' }}</td>
            <td>
              <span class="badge-pill {{ $emp->SEXE=='M'?'badge-primary':'badge-danger' }}">{{ $emp->SEXE ?? '-' }}</span>
            </td>
            <td>{{ $emp->DATE_NAISS ? \Carbon\Carbon::parse($emp->DATE_NAISS)->format('d/m/Y') : '-' }}</td>
            <td>{{ $emp->Sit_Familiale ?? '-' }}</td>
            <td>{{ $emp->TEL_PORTABLE ?? '-' }}</td>
            <td>
              @if($emp->position)
                <span class="badge-pill badge-success">{{ $emp->position->LIB_POSITION_FR }}</span>
              @else
                <span style="color:var(--secondary);">-</span>
              @endif
            </td>
            <td style="white-space:nowrap;">
              <a href="{{ route('employes.show', $emp) }}" class="btn-sm" title="Voir"><i class="fas fa-eye"></i></a>
              <a href="{{ route('employes.edit', $emp) }}" class="btn-sm" title="Modifier"><i class="fas fa-edit"></i></a>
              <form action="{{ route('employes.destroy', $emp) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cet employé ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm" title="Supprimer" style="color:var(--danger);"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="9" style="text-align:center;padding:30px;color:var(--secondary);">
            <i class="fas fa-users" style="font-size:24px;display:block;margin-bottom:8px;opacity:.3;"></i>
            Aucun employé trouvé
          </td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="pagination-wrap">
      <span style="font-size:12px;color:var(--secondary);">
        Affichage {{ $employes->firstItem() }}-{{ $employes->lastItem() }} sur {{ $employes->total() }} entrées
      </span>
      {{ $employes->links() }}
    </div>
  </div>
</div>
@endsection
