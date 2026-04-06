@extends('layouts.app')
@section('title', isset($diplome) ? 'Modifier Diplôme' : 'Ajouter un Diplôme')
@section('page-title', isset($diplome) ? 'Modifier Diplôme' : 'Ajouter un Diplôme')

@section('content')
<div class="page-header">
  <h1>{{ isset($diplome) ? 'Modifier le diplôme' : 'Enregistrer un Diplôme' }}</h1>
  <a href="{{ route('diplomes.index') }}" class="btn" style="background:#e3e6f0;color:var(--dark);">
    <i class="fas fa-arrow-left"></i> Retour
  </a>
</div>

<div class="card" style="max-width:750px;">
  <div class="card-header"><span class="card-title">Informations du Diplôme</span></div>
  <div class="card-body">
    <form method="POST"
          action="{{ isset($diplome) ? route('diplomes.update', $diplome) : route('diplomes.store') }}"
          enctype="multipart/form-data">
      @csrf
      @if(isset($diplome)) @method('PUT') @endif

      <div class="form-group">
        <label class="form-label">Agent *</label>
        <select name="code_agent" class="form-control form-select @error('code_agent') is-invalid @enderror" required>
          <option value="">-- Choisir un agent --</option>
          @foreach($employes as $emp)
            <option value="{{ $emp->COD_AG }}"
              {{ old('code_agent', $diplome->code_agent ?? '') == $emp->COD_AG ? 'selected' : '' }}>
              {{ $emp->NOM_PRENOM_FR }} ({{ $emp->CIN }})
            </option>
          @endforeach
        </select>
        @error('code_agent')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Intitulé du Diplôme *</label>
          <input type="text" name="LL_DIP" class="form-control @error('LL_DIP') is-invalid @enderror" required
                 placeholder="Ex: Licence en Informatique…"
                 value="{{ old('LL_DIP', $diplome->LL_DIP ?? '') }}">
          @error('LL_DIP')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Type *</label>
          <select name="TYPE_DIP" class="form-control form-select @error('TYPE_DIP') is-invalid @enderror" required>
            <option value="">-- Choisir --</option>
            <option value="SCOLAIRE" {{ old('TYPE_DIP', $diplome->TYPE_DIP ?? '') == 'SCOLAIRE' ? 'selected' : '' }}>Scolaire</option>
            <option value="PRO"      {{ old('TYPE_DIP', $diplome->TYPE_DIP ?? '') == 'PRO'      ? 'selected' : '' }}>Professionnel</option>
          </select>
          @error('TYPE_DIP')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Établissement de Formation</label>
          <input type="text" name="etablissement_formation" class="form-control"
                 placeholder="Ex: Université Mohammed V…"
                 value="{{ old('etablissement_formation', $diplome->etablissement_formation ?? '') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Date d'Obtention</label>
          <input type="date" name="DT_DIP" class="form-control"
                 value="{{ old('DT_DIP', isset($diplome->DT_DIP) ? \Carbon\Carbon::parse($diplome->DT_DIP)->format('Y-m-d') : '') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Mention <small style="color:var(--secondary);font-weight:400;">/20</small></label>
          <input type="number" name="montion" class="form-control" min="0" max="20" step="0.01"
                 placeholder="Ex: 15.5"
                 value="{{ old('montion', $diplome->montion ?? '') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Fichier PDF</label>
          <input type="file" name="PDF" class="form-control" accept=".pdf">
          @if(isset($diplome) && $diplome->PDF)
            <div style="margin-top:6px;font-size:11px;color:var(--secondary);">
              <i class="fas fa-file-pdf" style="color:var(--danger);"></i>
              PDF existant – <a href="{{ Storage::url($diplome->PDF) }}" target="_blank">Voir le fichier</a>
            </div>
          @endif
        </div>
      </div>

      <div style="display:flex;gap:12px;margin-top:24px;">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> {{ isset($diplome) ? 'Mettre à jour' : 'Enregistrer' }}
        </button>
        <a href="{{ route('diplomes.index') }}" class="btn" style="background:#e3e6f0;color:var(--dark);">Annuler</a>
      </div>
    </form>
  </div>
</div>
@endsection
