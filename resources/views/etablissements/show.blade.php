@extends('layouts.master')
@section('title', $etablisement->NOM_ETAB)
@section('page-title', 'Fiche Établissement')

@section('content')
<div class="page-header">
  <h1>{{ $etablisement->NOM_ETAB }}</h1>
  <div style="display:flex;gap:10px;">
    <a href="{{ route('etablissements.edit', [$etablisement,$etablisement->CD_ETAB]) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Modifier</a>
    <a href="{{ route('etablissements.index') }}" class="btn" style="background:#e3e6f0;color:var(--dark);"><i class="fas fa-arrow-left"></i> Retour</a>
  </div>
</div>

<div style="display:grid;grid-template-columns:280px 1fr;gap:20px;">
  <div class="card">
    <div class="card-body" style="padding:24px;text-align:center;">
      <div style="width:70px;height:70px;border-radius:12px;background:var(--success);display:flex;align-items:center;justify-content:center;font-size:28px;color:#fff;margin:0 auto 16px;">
        <i class="fas fa-school"></i>
      </div>
      <h3 style="font-size:15px;font-weight:800;color:var(--dark);margin-bottom:16px;">{{ $etablisement->NOM_ETAB }}</h3>
      <div style="font-size:12px;color:var(--secondary);line-height:2.2;text-align:left;">
        <div><i class="fas fa-hashtag" style="width:16px;color:var(--primary);"></i> Code: <strong>#{{ $etablisement->CD_ETAB }}</strong></div>
        <div><i class="fas fa-map-marker-alt" style="width:16px;color:var(--primary);"></i> {{ $etablisement->commune->LIB_COMMUNE_FR ?? '-' }}</div>
        <div><i class="fas fa-building" style="width:16px;color:var(--primary);"></i> {{ $etablisement->modiriya->nom_modiriya ?? '-' }}</div>
        <div><i class="fas fa-globe" style="width:16px;color:var(--primary);"></i> {{ $etablisement->type_milieu ?? '-' }}</div>
        <div><i class="fas fa-users" style="width:16px;color:var(--primary);"></i> {{ $etablisement->Nombre_eleves ?? '-' }} élèves</div>
        <div><i class="fas fa-home" style="width:16px;color:var(--primary);"></i> Logement: {{ $etablisement->Disponibilite_logement ?? '-' }}</div>
        <div><i class="fas fa-network-wired" style="width:16px;color:var(--primary);"></i> {{ $etablisement->netEtab->LIBELLE_net_etab ?? '-' }}</div>
        @if($etablisement->commune && $etablisement->commune->province)
          <div><i class="fas fa-map" style="width:16px;color:var(--primary);"></i> {{ $etablisement->commune->province->LIB_PROVINCE_FR ?? '-' }}</div>
          <div><i class="fas fa-flag" style="width:16px;color:var(--primary);"></i> {{ $etablisement->commune->province->region->LIB_REGION_FR ?? '-' }}</div>
        @endif
      </div>
    </div>
  </div>

  <div>
    <div class="card">
      <div class="card-header">
        <span class="card-title"><i class="fas fa-users" style="margin-right:6px;"></i>Personnel affecté ({{ $etablisement->affectations->count() }})</span>
      </div>
      <div class="card-body" style="padding:0;">
        <table>
          <thead><tr><th>Agent</th><th>CIN</th><th>Fonction</th><th>Date Poste</th><th>Mode</th></tr></thead>
          <tbody>
            @forelse($etablisement->affectations as $aff)
            <tr>
              <td>
                <a href="{{ route('employes.show', $aff->employer) }}" style="font-weight:700;color:var(--primary);text-decoration:none;">
                  {{ $aff->employer->NOM_PRENOM_FR ?? 'N/A' }}
                </a>
              </td>
              <td>{{ $aff->employer->CIN ?? '-' }}</td>
              <td>{{ $aff->fonction->LIB_FONCTION_FR ?? '-' }}</td>
              <td>{{ $aff->DT_AFF_POSTE ? $aff->DT_AFF_POSTE->format('d/m/Y') : '-' }}</td>
              <td><span class="badge-pill badge-primary">{{ $aff->Mode_Affectation ?? '-' }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:var(--secondary);padding:20px;">Aucun personnel affecté</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
