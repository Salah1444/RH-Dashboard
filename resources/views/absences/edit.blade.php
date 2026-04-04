@extends('layouts.app')
@section('title', isset($absence) ? 'Modifier Absence' : 'Nouvelle Absence')
@section('page-title', isset($absence) ? 'Modifier Absence' : 'Nouvelle Absence')

@section('content')
<div class="page-header">
  <h1>{{ isset($absence) ? 'Modifier l\'absence' : 'Enregistrer une Absence' }}</h1>
  <a href="{{ route('absences.index') }}" class="btn" style="background:#e3e6f0;color:var(--dark);"><i class="fas fa-arrow-left"></i> Retour</a>
</div>
<div class="card" style="max-width:700px;">
  <div class="card-header"><span class="card-title">Informations</span></div>
  <div class="card-body">
    <form method="POST"
          action="{{ isset($absence) ? route('absences.update', $absence) : route('absences.store') }}"
          enctype="multipart/form-data">
      @csrf
      @if(isset($absence)) @method('PUT') @endif

      <div class="form-group">
        <label class="form-label">Agent *</label>
        <select name="code_agent" class="form-control form-select @error('code_agent') is-invalid @enderror" required>
          <option value="">-- Choisir --</option>
          @foreach($employes as $emp)
            <option value="{{ $emp->COD_AG }}" {{ old('code_agent', $absence->code_agent ?? '')==$emp->COD_AG?'selected':'' }}>
              {{ $emp->NOM_PRENOM_FR }} ({{ $emp->CIN }})
            </option>
          @endforeach
        </select>
        @error('code_agent')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Type de Congé (optionnel)</label>
        <select name="congee_id" class="form-control form-select">
          <option value="">Absence simple</option>
          @foreach($congees as $cg)
            <option value="{{ $cg->id_congee }}" {{ old('congee_id', $absence->congee_id ?? '')==$cg->id_congee?'selected':'' }}>
              {{ $cg->type_congee }} ({{ $cg->nombre_jrs }} jrs)
            </option>
          @endforeach
        </select>
      </div>

      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Date Début *</label>
          <input type="date" name="date_debut" class="form-control @error('date_debut') is-invalid @enderror" required
                 value="{{ old('date_debut', isset($absence->date_debut) ? $absence->date_debut->format('Y-m-d') : '') }}">
          @error('date_debut')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Date Fin</label>
          <input type="date" name="date_fin" class="form-control"
                 value="{{ old('date_fin', isset($absence->date_fin) ? $absence->date_fin->format('Y-m-d') : '') }}">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Absence justifiée ?</label>
        <div style="display:flex;gap:20px;margin-top:6px;">
          <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-weight:600;">
            <input type="radio" name="is_justify" value="1" {{ old('is_justify', $absence->is_justify ?? '') == '1' ? 'checked' : '' }}>
            <span class="badge-pill badge-success">Oui</span>
          </label>
          <label style="display:flex;align-items:center;gap:6px;cursor:pointer;font-weight:600;">
            <input type="radio" name="is_justify" value="0" {{ old('is_justify', isset($absence) ? ($absence->is_justify ? '' : '0') : '') == '0' ? 'checked' : '' }}>
            <span class="badge-pill badge-danger">Non</span>
          </label>
        </div>
        @error('is_justify')<div class="invalid-feedback" style="display:block;">{{ $message }}</div>@enderror
      </div>

      <div class="form-group">
        <label class="form-label">Certificat (PDF/Image)</label>
        <input type="file" name="certificat" class="form-control" accept=".pdf,.jpg,.png">
        @if(isset($absence) && $absence->certificat)
          <div style="margin-top:6px;font-size:11px;color:var(--secondary);">
            <i class="fas fa-file" style="color:var(--info);"></i>
            Certificat existant – <a href="{{ Storage::url($absence->certificat) }}" target="_blank">Voir</a>
          </div>
        @endif
      </div>

      <div style="display:flex;gap:12px;margin-top:24px;">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ isset($absence) ? 'Mettre à jour' : 'Enregistrer' }}</button>
        <a href="{{ route('absences.index') }}" class="btn" style="background:#e3e6f0;color:var(--dark);">Annuler</a>
      </div>
    </form>
  </div>
</div>
@endsection