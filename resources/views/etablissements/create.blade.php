@extends('layouts.master')
@section('title', isset($etablisement) ? 'Modifier Établissement' : 'Nouvel Établissement')
@section('page-title', isset($etablisement) ? 'Modifier Établissement' : 'Nouvel Établissement')

@section('content')
<div class="page-header">
  <h1>{{ isset($etablisement) ? $etablisement->NOM_ETAB : 'Créer un Établissement' }}</h1>
  <a href="{{ route('etablissements.index') }}" class="btn" style="background:#e3e6f0;color:var(--dark);"><i class="fas fa-arrow-left"></i> Retour</a>
</div>
<div class="card" style="max-width:800px;">
  <div class="card-header"><span class="card-title">Informations</span></div>
  <div class="card-body">
    <form method="POST" action="{{ isset($etablisement) ? route('etablissements.update', $etablisement) : route('etablissements.store') }}">
      @csrf
      @if(isset($etablisement)) @method('PUT') @endif

      <div class="form-group">
        <label class="form-label">Nom de l'Établissement *</label>
        <input type="text" name="NOM_ETAB" class="form-control @error('NOM_ETAB') is-invalid @enderror" required
               value="{{ old('NOM_ETAB', $etablisement->NOM_ETAB ?? '') }}">
        @error('NOM_ETAB')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Type de Milieu</label>
          <select name="type_milieu" class="form-control form-select">
            <option value="">-- Choisir --</option>
            <option value="Urbain" {{ old('type_milieu', $etablisement->type_milieu ?? '')=='Urbain'?'selected':'' }}>Urbain</option>
            <option value="Rural"  {{ old('type_milieu', $etablisement->type_milieu ?? '')=='Rural'?'selected':'' }}>Rural</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Nombre d'Élèves</label>
          <input type="number" name="Nombre_eleves" class="form-control" min="0"
                 value="{{ old('Nombre_eleves', $etablisement->Nombre_eleves ?? '') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Commune</label>
          <select name="cd_commune" class="form-control form-select">
            <option value="">-- Choisir --</option>
            @foreach($communes as $com)
              <option value="{{ $com->CD_COM }}" {{ old('cd_commune', $etablisement->cd_commune ?? '')==$com->CD_COM?'selected':'' }}>{{ $com->LIB_COMMUNE_FR }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Modiriya</label>
          <select name="modiriya_id" class="form-control form-select">
            <option value="">-- Choisir --</option>
            @foreach($modiriyas as $mod)
              <option value="{{ $mod->modiriya_id }}" {{ old('modiriya_id', $etablisement->modiriya_id ?? '')==$mod->modiriya_id?'selected':'' }}>{{ $mod->nom_modiriya }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Réseau d'Établissements</label>
          <select name="CD_NETAB" class="form-control form-select">
            <option value="">-- Choisir --</option>
            @foreach($netEtabs as $net)
              <option value="{{ $net->CD_NETAB }}" {{ old('CD_NETAB', $etablisement->CD_NETAB ?? '')==$net->CD_NETAB?'selected':'' }}>{{ $net->LIBELLE_net_etab }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Disponibilité Logement</label>
          <select name="Disponibilite_logement" class="form-control form-select">
            <option value="">-- Choisir --</option>
            <option value="Oui" {{ old('Disponibilite_logement', $etablisement->Disponibilite_logement ?? '')=='Oui'?'selected':'' }}>Oui</option>
            <option value="Non" {{ old('Disponibilite_logement', $etablisement->Disponibilite_logement ?? '')=='Non'?'selected':'' }}>Non</option>
          </select>
        </div>
      </div>

      <div style="display:flex;gap:12px;margin-top:24px;">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ isset($etablisement) ? 'Mettre à jour' : 'Enregistrer' }}</button>
        <a href="{{ route('etablissements.index') }}" class="btn" style="background:#e3e6f0;color:var(--dark);">Annuler</a>
      </div>
    </form>
  </div>
</div>
@endsection
