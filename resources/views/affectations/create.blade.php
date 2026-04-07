@extends('layouts.master')
@section('title', isset($affectation) ? 'Modifier Affectation' : 'Nouvelle Affectation')
@section('page-title', isset($affectation) ? 'Modifier Affectation' : 'Nouvelle Affectation')

@section('content')
<div class="page-header">
  <h1>{{ isset($affectation) ? 'Modifier l\'affectation' : 'Créer une Affectation' }}</h1>
  <a href="{{ route('affectations.index') }}" class="btn" style="background:#e3e6f0;color:var(--dark);">
    <i class="fas fa-arrow-left"></i> Retour
  </a>
</div>

<div class="card">
  <div class="card-header"><span class="card-title">Informations de l'Affectation</span></div>
  <div class="card-body">
    <form method="POST"
          action="{{ isset($affectation) ? route('affectations.update', $affectation) : route('affectations.store') }}">
      @csrf
      @if(isset($affectation)) @method('PUT') @endif

      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Agent *</label>
          <select name="code_agent" class="form-control form-select @error('code_agent') is-invalid @enderror" required>
            <option value="">-- Choisir un agent --</option>
            @foreach($employes as $emp)
              <option value="{{ $emp->COD_AG }}"
                {{ old('code_agent', $affectation->code_agent ?? '')==$emp->COD_AG?'selected':'' }}>
                {{ $emp->NOM_PRENOM_FR }} ({{ $emp->CIN }})
              </option>
            @endforeach
          </select>
          @error('code_agent')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label class="form-label">Établissement</label>
          <select name="code_etab" class="form-control form-select">
            <option value="">-- Choisir --</option>
            @foreach($etablissements as $etab)
              <option value="{{ $etab->CD_ETAB }}"
                {{ old('code_etab', $affectation->code_etab ?? '')==$etab->CD_ETAB?'selected':'' }}>
                {{ $etab->NOM_ETAB }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Fonction</label>
          <select name="fonction_id" class="form-control form-select">
            <option value="">-- Choisir --</option>
            @foreach($fonctions as $fonc)
              <option value="{{ $fonc->CODE_FONCTION }}"
                {{ old('fonction_id', $affectation->fonction_id ?? '')==$fonc->CODE_FONCTION?'selected':'' }}>
                {{ $fonc->LIB_FONCTION_FR }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Mode d'Affectation</label>
          <select name="Mode_Affectation" class="form-control form-select">
            <option value="">-- Choisir --</option>
            @foreach(['Mutation','Nouveau','Détachement','Intérim','Révision'] as $mode)
              <option value="{{ $mode }}" {{ old('Mode_Affectation', $affectation->Mode_Affectation ?? '')==$mode?'selected':'' }}>{{ $mode }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Date Poste</label>
          <input type="date" name="DT_AFF_POSTE" class="form-control"
                 value="{{ old('DT_AFF_POSTE', isset($affectation->DT_AFF_POSTE) ? $affectation->DT_AFF_POSTE->format('Y-m-d') : '') }}">
        </div>

        <div class="form-group">
          <label class="form-label">Date Début Affectation</label>
          <input type="date" name="DATE_DEBUT_AFF" class="form-control"
                 value="{{ old('DATE_DEBUT_AFF', isset($affectation->DATE_DEBUT_AFF) ? $affectation->DATE_DEBUT_AFF->format('Y-m-d') : '') }}">
        </div>

        <div class="form-group">
          <label class="form-label">Date Aff. Délégation</label>
          <input type="date" name="Date_aff_delegation" class="form-control"
                 value="{{ old('Date_aff_delegation', isset($affectation->Date_aff_delegation) ? $affectation->Date_aff_delegation->format('Y-m-d') : '') }}">
        </div>

        <div class="form-group">
          <label class="form-label">Date Aff. AREF</label>
          <input type="date" name="Date_aff_aref" class="form-control"
                 value="{{ old('Date_aff_aref', isset($affectation->Date_aff_aref) ? $affectation->Date_aff_aref->format('Y-m-d') : '') }}">
        </div>
      </div>

      <div style="display:flex;gap:12px;margin-top:24px;">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> {{ isset($affectation) ? 'Mettre à jour' : 'Enregistrer' }}
        </button>
        <a href="{{ route('affectations.index') }}" class="btn" style="background:#e3e6f0;color:var(--dark);">Annuler</a>
      </div>
    </form>
  </div>
</div>
@endsection
