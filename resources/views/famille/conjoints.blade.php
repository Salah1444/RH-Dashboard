@extends('layouts.master')
@section('title','Conjoints')
@section('page-title','Gestion des Conjoints')

@section('content')
<div class="page-header">
  <h1>Conjoints</h1>
  <a href="{{ route('famille.enfants') }}" class="btn" style="background:#e3e6f0;color:var(--dark);">
    <i class="fas fa-child"></i> Voir les Enfants
  </a>
</div>

<!-- Import Excel -->
<x-excel-import
  :import-route="route('famille.conjoints.import')"
  :template-route="route('famille.conjoints.template')"
  label="conjoints"
/>

<div style="display:grid;grid-template-columns:380px 1fr;gap:20px;">

  {{-- Formulaire ajout --}}
  <div class="card" style="align-self:start;">
    <div class="card-header"><span class="card-title"><i class="fas fa-plus-circle" style="margin-right:6px;"></i>Ajouter un Conjoint</span></div>
    <div class="card-body">
      <form method="POST" action="{{ route('famille.conjoints.store') }}">
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
        <div class="form-group">
          <label class="form-label">Nom & Prénom du Conjoint *</label>
          <input type="text" name="nom_prenom_conjoint" class="form-control @error('nom_prenom_conjoint') is-invalid @enderror"
                 required value="{{ old('nom_prenom_conjoint') }}" maxlength="200">
          @error('nom_prenom_conjoint')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-grid">
          <div class="form-group">
            <label class="form-label">CIN Conjoint</label>
            <input type="text" name="cin_conj" class="form-control" value="{{ old('cin_conj') }}" maxlength="20">
          </div>
          <div class="form-group">
            <label class="form-label">Rang</label>
            <input type="number" name="rang_conj" class="form-control" value="{{ old('rang_conj') }}" min="1">
          </div>
          <div class="form-group">
            <label class="form-label">Nationalité</label>
            <input type="text" name="nationalite_conj" class="form-control" value="{{ old('nationalite_conj') }}" maxlength="80">
          </div>
          <div class="form-group">
            <label class="form-label">Date Sit. Familiale</label>
            <input type="date" name="DATE_SIT_FAM" class="form-control" value="{{ old('DATE_SIT_FAM') }}">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Fonction du Conjoint</label>
          <input type="text" name="fonction_conj" class="form-control" value="{{ old('fonction_conj') }}" maxlength="150">
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
      <span class="card-title">Liste des Conjoints ({{ $totalConj }})</span>
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
              <th>Agent</th><th>Conjoint</th><th>CIN</th><th>Nationalité</th><th>Fonction</th><th>Date</th><th></th>
            </tr>
          </thead>
          <tbody>
            @forelse($conjoints as $conj)
            <tr>
              <td>
                <a href="{{ route('employes.show', $conj->employer) }}" style="font-weight:700;color:var(--primary);text-decoration:none;">
                  {{ $conj->employer->NOM_PRENOM_FR ?? 'N/A' }}
                </a>
              </td>
              <td style="font-weight:600;">{{ $conj->nom_prenom_conjoint }}</td>
              <td>{{ $conj->cin_conj ?? '-' }}</td>
              <td>{{ $conj->nationalite_conj ?? '-' }}</td>
              <td>{{ $conj->fonction_conj ?? '-' }}</td>
              <td>{{ $conj->DATE_SIT_FAM ? \Carbon\Carbon::parse($conj->DATE_SIT_FAM)->format('d/m/Y') : '-' }}</td>
              <td>
                <form action="{{ route('famille.conjoints.destroy', $conj) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-sm" style="color:var(--danger);"><i class="fas fa-trash"></i></button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" style="text-align:center;padding:30px;color:var(--secondary);">
                <i class="fas fa-heart-broken" style="font-size:24px;display:block;margin-bottom:8px;opacity:.3;"></i>
                Aucun conjoint enregistré
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="pagination-wrap">
        <span style="font-size:12px;color:var(--secondary);">{{ $conjoints->total() }} conjoints au total</span>
        {{ $conjoints->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
