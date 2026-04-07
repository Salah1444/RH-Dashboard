@extends('layouts.master')
@section('title', isset($employer) ? 'Modifier Employé' : 'Nouvel Employé')
@section('page-title', isset($employer) ? 'Modifier Employé' : 'Nouvel Employé')

@section('content')
<div class="page-header">
  <h1>{{ isset($employer) ? 'Modifier : '.$employer->NOM_PRENOM_FR : 'Ajouter un Employé' }}</h1>
  <a href="{{ route('employes.index') }}" class="btn" style="background:#e3e6f0;color:var(--dark);">
    <i class="fas fa-arrow-left"></i> Retour
  </a>
</div>

<div class="card">
  <div class="card-header"><span class="card-title">Informations Personnelles</span></div>
  <div class="card-body">
    <form method="POST"
          action="{{ isset($employer) ? route('employes.update', $employer) : route('employes.store') }}"
          enctype="multipart/form-data">
      @csrf
      @if(isset($employer)) @method('PUT') @endif

      <!-- Section 1: Identité -->
      <h4 style="font-size:13px;font-weight:800;color:var(--primary);margin-bottom:14px;text-transform:uppercase;letter-spacing:.8px;">
        <i class="fas fa-id-card" style="margin-right:6px;"></i> Identité
      </h4>
      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Nom & Prénom (FR) *</label>
          <input type="text" name="NOM_PRENOM_FR" class="form-control @error('NOM_PRENOM_FR') is-invalid @enderror"
                 value="{{ old('NOM_PRENOM_FR', $employer->NOM_PRENOM_FR ?? '') }}" required>
          @error('NOM_PRENOM_FR')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Nom & Prénom (AR)</label>
          <input type="text" name="NOM_PRENOM_AR" class="form-control" dir="rtl"
                 value="{{ old('NOM_PRENOM_AR', $employer->NOM_PRENOM_AR ?? '') }}">
        </div>
        <div class="form-group">
          <label class="form-label">CIN *</label>
          <input type="text" name="CIN" class="form-control @error('CIN') is-invalid @enderror"
                 value="{{ old('CIN', $employer->CIN ?? '') }}" required maxlength="20">
          @error('CIN')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Sexe</label>
          <select name="SEXE" class="form-control form-select">
            <option value="">-- Choisir --</option>
            <option value="M" {{ old('SEXE', $employer->SEXE ?? '')=='M'?'selected':'' }}>Masculin</option>
            <option value="F" {{ old('SEXE', $employer->SEXE ?? '')=='F'?'selected':'' }}>Féminin</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Date de Naissance</label>
          <input type="date" name="DATE_NAISS" class="form-control"
                 value="{{ old('DATE_NAISS', isset($employer->DATE_NAISS) ? \Carbon\Carbon::parse($employer->DATE_NAISS)->format('Y-m-d') : '') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Lieu de Naissance</label>
          <input type="text" name="LIEU_NAISS" class="form-control"
                 value="{{ old('LIEU_NAISS', $employer->LIEU_NAISS ?? '') }}" maxlength="150">
        </div>
        <div class="form-group">
          <label class="form-label">Situation Familiale</label>
          <select name="Sit_Familiale" class="form-control form-select">
            <option value="">-- Choisir --</option>
            @foreach(['Célibataire','Marié(e)','Divorcé(e)','Veuf/Veuve'] as $sit)
              <option value="{{ $sit }}" {{ old('Sit_Familiale', $employer->Sit_Familiale ?? '')==$sit?'selected':'' }}>{{ $sit }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Photo</label>
          <input type="file" name="photo" class="form-control" accept="image/*">
          @if(isset($employer) && $employer->photo && $employer->photo !== 'default.png')
            <div style="margin-top:8px;font-size:11px;color:var(--secondary);">
              <img src="{{ Storage::url($employer->photo) }}" style="height:40px;border-radius:4px;"> Photo actuelle
            </div>
          @endif
        </div>
      </div>

      <hr style="margin:20px 0;border-color:#e3e6f0;">

      <!-- Section 2: Contact -->
      <h4 style="font-size:13px;font-weight:800;color:var(--primary);margin-bottom:14px;text-transform:uppercase;letter-spacing:.8px;">
        <i class="fas fa-phone" style="margin-right:6px;"></i> Contact & Adresse
      </h4>
      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Tél. Fixe</label>
          <input type="text" name="TEL_FIXE" class="form-control"
                 value="{{ old('TEL_FIXE', $employer->TEL_FIXE ?? '') }}" maxlength="20">
        </div>
        <div class="form-group">
          <label class="form-label">Tél. Portable</label>
          <input type="text" name="TEL_PORTABLE" class="form-control"
                 value="{{ old('TEL_PORTABLE', $employer->TEL_PORTABLE ?? '') }}" maxlength="20">
        </div>
        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="ADRESSE_ELEC" class="form-control @error('ADRESSE_ELEC') is-invalid @enderror"
                 value="{{ old('ADRESSE_ELEC', $employer->ADRESSE_ELEC ?? '') }}" maxlength="150">
          @error('ADRESSE_ELEC')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Ville (Commune)</label>
          <select name="ville_id" class="form-control form-select">
            <option value="">-- Choisir --</option>
            @foreach($communes as $com)
              <option value="{{ $com->CD_COM }}" {{ old('ville_id', $employer->ville_id ?? '')==$com->CD_COM?'selected':'' }}>
                {{ $com->LIB_COMMUNE_FR }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group" style="grid-column:1/-1;">
          <label class="form-label">Adresse (FR)</label>
          <input type="text" name="ADRESSE_FR" class="form-control"
                 value="{{ old('ADRESSE_FR', $employer->ADRESSE_FR ?? '') }}" maxlength="255">
        </div>
      </div>

      <hr style="margin:20px 0;border-color:#e3e6f0;">

      <!-- Section 3: Administratif -->
      <h4 style="font-size:13px;font-weight:800;color:var(--primary);margin-bottom:14px;text-transform:uppercase;letter-spacing:.8px;">
        <i class="fas fa-briefcase" style="margin-right:6px;"></i> Données Administratives
      </h4>
      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Position</label>
          <select name="position_id" class="form-control form-select">
            <option value="">-- Choisir --</option>
            @foreach($positions as $pos)
              <option value="{{ $pos->COD_POS }}" {{ old('position_id', $employer->position_id ?? '')==$pos->COD_POS?'selected':'' }}>
                {{ $pos->LIB_POSITION_FR }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">RIB</label>
          <input type="text" name="RIB" class="form-control"
                 value="{{ old('RIB', $employer->RIB ?? '') }}" maxlength="30">
        </div>
      </div>

      <div style="display:flex;gap:12px;margin-top:24px;">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> {{ isset($employer) ? 'Mettre à jour' : 'Enregistrer' }}
        </button>
        <a href="{{ route('employes.index') }}" class="btn" style="background:#e3e6f0;color:var(--dark);">Annuler</a>
      </div>
    </form>
  </div>
</div>
@endsection
