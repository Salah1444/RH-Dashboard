@extends('layouts.master')
@section('title', isset($congee) ? 'Modifier Congé' : 'Nouveau Congé')
@section('page-title', isset($congee) ? 'Modifier Congé' : 'Nouveau Congé')

@section('content')
<div class="page-header">
  <h1>{{ isset($congee) ? 'Modifier le congé' : 'Créer un congé' }}</h1>
  <a href="{{ route('congees.index') }}" class="btn" style="background:#e3e6f0;color:var(--dark);"><i class="fas fa-arrow-left"></i> Retour</a>
</div>
<div class="card" style="max-width:600px;">
  <div class="card-header"><span class="card-title">Informations du congé</span></div>
  <div class="card-body">
    <form method="POST" action="{{ isset($congee) ? route('congees.update', $congee) : route('congees.store') }}">
      @csrf
      @if(isset($congee)) @method('PUT') @endif
      <div class="form-group">
        <label class="form-label">Type de Congé *</label>
        <input type="text" name="type_congee" class="form-control @error('type_congee') is-invalid @enderror" required
               placeholder="Ex: Congé annuel, Congé maladie…"
               value="{{ old('type_congee', $congee->type_congee ?? '') }}">
        @error('type_congee')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">Date Début *</label>
          <input type="date" name="date_debut" class="form-control @error('date_debut') is-invalid @enderror" required
                 value="{{ old('date_debut', isset($congee->date_debut) ? \Carbon\Carbon::parse($congee->date_debut)->format('Y-m-d') : '') }}">
          @error('date_debut')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Date Fin *</label>
          <input type="date" name="date_fin" class="form-control @error('date_fin') is-invalid @enderror" required
                 value="{{ old('date_fin', isset($congee->date_fin) ? \Carbon\Carbon::parse($congee->date_fin)->format('Y-m-d') : '') }}">
          @error('date_fin')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>
      <div class="form-group">
        <label class="form-label">Nombre de Jours <small style="font-weight:400;color:var(--secondary);">(calculé automatiquement si vide)</small></label>
        <input type="number" name="nombre_jrs" class="form-control" min="1"
               value="{{ old('nombre_jrs', $congee->nombre_jrs ?? '') }}">
      </div>
      <div style="display:flex;gap:12px;margin-top:24px;">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ isset($congee) ? 'Mettre à jour' : 'Enregistrer' }}</button>
        <a href="{{ route('congees.index') }}" class="btn" style="background:#e3e6f0;color:var(--dark);">Annuler</a>
      </div>
    </form>
  </div>
</div>
@endsection
