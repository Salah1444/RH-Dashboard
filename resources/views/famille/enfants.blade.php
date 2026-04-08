@extends('layouts.master')
@section('title','Enfants')
@section('page-title','Gestion des Enfants')

@section('content')
<div class="page-header">
  <h1>Enfants à Charge</h1>
  <a href="{{ route('famille.conjoints') }}" class="btn" style="background:#e3e6f0;color:var(--dark);">
    <i class="fas fa-ring"></i> Voir les Conjoints
  </a>
</div>


<!-- Import Excel -->
<x-excel-import
  :import-route="route('famille.enfants.import')"
  :template-route="route('famille.enfants.template')"
  label="enfants"
/>

<div style="display:grid;grid-template-columns:380px 1fr;gap:20px;">

  {{-- Formulaire ajout --}}
  <div class="card" style="align-self:start;">
    <div class="card-header"><span class="card-title"><i class="fas fa-plus-circle" style="margin-right:6px;"></i>Ajouter un Enfant</span></div>
    <div class="card-body">
      <form method="POST" action="{{ route('famille.enfants.store') }}">
        @csrf
        <div class="form-group">
          <label class="form-label">Agent *</label>
          <select name="code_agent" class="form-control form-select @error('code_agent') is-invalid @enderror" required>
            <option value="">-- Choisir --</option>
            @foreach($employes as $emp)
              <option value="{{ $emp->COD_AG }}" {{ old('code_agent')==$emp->COD_AG?'selected':'' }}>
                {{ $emp->NOM_PRENOM_FR }} ({{ $emp->CIN }})
              </option>
            @endforeach
          </select>
          @error('code_agent')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-grid">
          <div class="form-group">
            <label class="form-label">Nom *</label>
            <input type="text" name="nom_enf" class="form-control @error('nom_enf') is-invalid @enderror"
                   required value="{{ old('nom_enf') }}" maxlength="200">
            @error('nom_enf')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" maxlength="200">
          </div>
          <div class="form-group">
            <label class="form-label">Rang</label>
            <input type="number" name="rang_enf" class="form-control" value="{{ old('rang_enf') }}" min="1">
          </div>
          <div class="form-group">
            <label class="form-label">Date de Naissance</label>
            <input type="date" name="date_naissance_enf" class="form-control" value="{{ old('date_naissance_enf') }}">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Lien Juridique</label>
          <select name="lien_juridique" class="form-control form-select">
            <option value="">-- Choisir --</option>
            @foreach(['Enfant légitime','Enfant adoptif','Enfant recueilli'] as $l)
              <option value="{{ $l }}" {{ old('lien_juridique')==$l?'selected':'' }}>{{ $l }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Situation de l'Enfant</label>
          <select name="situation_enf" class="form-control form-select">
            <option value="">-- Choisir --</option>
            @foreach(['Scolarisé','En formation','Handicapé','Autre'] as $s)
              <option value="{{ $s }}" {{ old('situation_enf')==$s?'selected':'' }}>{{ $s }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Gardien (si applicable)</label>
          <select name="gard_id" class="form-control form-select">
            <option value="">Aucun</option>
            @foreach($gardes as $g)
              <option value="{{ $g->id_garde }}" {{ old('gard_id')==$g->id_garde?'selected':'' }}>
                {{ $g->nom_prenom_gardeur }}
              </option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">
          <i class="fas fa-save"></i> Enregistrer
        </button>
      </form>
    </div>
  </div>

  {{-- Liste --}}
  <div class="card">
    <div class="card-header">
      <span class="card-title">Liste des Enfants ({{ $totalEnf }})</span>
      <form method="GET" style="display:flex;gap:8px;">
        <input type="text" name="search" class="form-control" placeholder="Rechercher…"
               value="{{ request('search') }}" style="width:200px;padding:5px 10px;">
        <button type="submit" class="btn-sm"><i class="fas fa-search"></i></button>
      </form>
    </div>
    <div class="card-body" style="padding:0;">
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th>Agent</th><th>Nom de l'Enfant</th><th>Prénom</th><th>Rang</th>
              <th>Date Naiss.</th><th>Lien</th><th>Situation</th><th></th>
            </tr>
          </thead>
          <tbody>
            @forelse($enfants as $enf)
            <tr>
              <td>
                <a href="{{ route('employes.show', $enf->employer) }}" style="font-weight:700;color:var(--primary);text-decoration:none;">
                  {{ $enf->employer->NOM_PRENOM_FR ?? 'N/A' }}
                </a>
              </td>
              <td style="font-weight:600;">{{ $enf->nom_enf }}</td>
              <td>{{ $enf->prenom ?? '-' }}</td>
              <td>
                @if($enf->rang_enf)
                  <span class="badge-pill badge-secondary">{{ $enf->rang_enf }}</span>
                @else -
                @endif
              </td>
              <td>{{ $enf->date_naissance_enf ? \Carbon\Carbon::parse($enf->date_naissance_enf)->format('d/m/Y') : '-' }}</td>
              <td>{{ $enf->lien_juridique ?? '-' }}</td>
              <td>
                @if($enf->situation_enf)
                  <span class="badge-pill badge-info">{{ $enf->situation_enf }}</span>
                @else -
                @endif
              </td>
              <td>
                <form action="{{ route('famille.enfants.destroy', $enf) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-sm" style="color:var(--danger);"><i class="fas fa-trash"></i></button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" style="text-align:center;padding:30px;color:var(--secondary);">
                <i class="fas fa-baby" style="font-size:24px;display:block;margin-bottom:8px;opacity:.3;"></i>
                Aucun enfant enregistré
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="pagination-wrap">
        <span style="font-size:12px;color:var(--secondary);">{{ $enfants->total() }} enfants au total</span>
        {{ $enfants->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
