@extends('layouts.master')
@section('title', $employer->NOM_PRENOM_FR)
@section('page-title', 'Fiche Employé')

@section('content')
<div class="page-header">
  <h1>{{ $employer->NOM_PRENOM_FR }}</h1>
  
  <div style="display:flex;gap:10px;">
    <a href="{{ route('employes.edit', $employer) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Modifier</a>
    <a href="{{ route('employes.index') }}" class="btn" style="background:#e3e6f0;color:var(--dark);"><i class="fas fa-arrow-left"></i> Retour</a>
  </div>
</div>

<div style="display:grid;grid-template-columns:300px 1fr;gap:20px;margin-bottom:20px;">
  <!-- Carte identité -->
  <div class="card">
    <div class="card-body" style="text-align:center;padding:30px 20px;">
      @if($employer->photo && $employer->photo !== 'default.png')
        <img src="{{ Storage::url($employer->photo) }}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;margin-bottom:12px;">
      @else
        <div style="width:80px;height:80px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:#fff;margin:0 auto 12px;">
          {{ $employer->initiales }}
        </div>
      @endif
      <h3 style="font-size:16px;font-weight:800;color:var(--dark);margin-bottom:4px;">{{ $employer->NOM_PRENOM_FR }}</h3>
      @if($employer->NOM_PRENOM_AR)
        <p style="font-size:14px;color:var(--secondary);direction:rtl;">{{ $employer->NOM_PRENOM_AR }}</p>
      @endif
      <div style="margin:12px 0;">
        @if($employer->position)
          <span class="badge-pill badge-success">{{ $employer->position->LIB_POSITION_FR }}</span>
        @endif
      </div>
      <div style="font-size:12px;color:var(--secondary);line-height:2;">
        <div><i class="fas fa-id-card" style="width:16px;color:var(--primary);"></i> <strong>CIN:</strong> {{ $employer->CIN ?? '-' }}</div>
        <div><i class="fas fa-hashtag" style="width:16px;color:var(--primary);"></i> <strong>Code:</strong> #{{ $employer->COD_AG }}</div>
        <div><i class="fas fa-phone" style="width:16px;color:var(--primary);"></i> {{ $employer->TEL_PORTABLE ?? '-' }}</div>
        <div><i class="fas fa-envelope" style="width:16px;color:var(--primary);"></i> {{ $employer->ADRESSE_ELEC ?? '-' }}</div>
        <div><i class="fas fa-calendar" style="width:16px;color:var(--primary);"></i> {{ $employer->DATE_NAISS ? \Carbon\Carbon::parse($employer->DATE_NAISS)->format('d/m/Y') : '-' }}</div>
        <div><i class="fas fa-map-marker-alt" style="width:16px;color:var(--primary);"></i> {{ $employer->commune->LIB_COMMUNE_FR ?? '-' }}</div>
        <div><i class="fas fa-heart" style="width:16px;color:var(--primary);"></i> {{ $employer->Sit_Familiale ?? '-' }}</div>
      </div>
    </div>
  </div>

  <!-- Tabs -->
  <div>
    <!-- Affectations -->
    <div class="card" style="margin-bottom:16px;">
      <div class="card-header"><span class="card-title"><i class="fas fa-map-pin" style="margin-right:6px;"></i>Affectations</span></div>
      <div class="card-body" style="padding:0;">
        <table>
          <thead><tr><th>Établissement</th><th>Fonction</th><th>Date Poste</th><th>Date Début</th><th>Mode</th></tr></thead>
          <tbody>
            @forelse($employer->affectations as $aff)
            <tr>
              <td>{{ $aff->etablisement->NOM_ETAB ?? '-' }}</td>
              <td>{{ $aff->fonction->LIB_FONCTION_FR ?? '-' }}</td>
              <td>{{ $aff->DT_AFF_POSTE ? $aff->DT_AFF_POSTE->format('d/m/Y') : '-' }}</td>
              <td>{{ $aff->DATE_DEBUT_AFF ? $aff->DATE_DEBUT_AFF->format('d/m/Y') : '-' }}</td>
              <td><span class="badge-pill badge-primary">{{ $aff->Mode_Affectation ?? '-' }}</span></td>
            </tr>
            @empty <tr><td colspan="5" style="text-align:center;color:var(--secondary);">Aucune affectation</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Grades & Cadres -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
      <div class="card">
        <div class="card-header"><span class="card-title">Grades</span></div>
        <div class="card-body" style="padding:0;">
          <table>
            <thead><tr><th>Grade</th><th>Date Eff.</th></tr></thead>
            <tbody>
              @forelse($employer->gradeHistories as $gh)
              <tr>
                <td>{{ $gh->grade->Lib_grade_FR ?? '-' }}</td>
                <td>{{ $gh->DAT_EFF_GR ? \Carbon\Carbon::parse($gh->DAT_EFF_GR)->format('d/m/Y') : '-' }}</td>
              </tr>
              @empty <tr><td colspan="2" style="text-align:center;color:var(--secondary);">-</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="card">
        <div class="card-header"><span class="card-title">Cadres</span></div>
        <div class="card-body" style="padding:0;">
          <table>
            <thead><tr><th>Cadre</th><th>Date Aff.</th></tr></thead>
            <tbody>
              @forelse($employer->cadreHistories as $ch)
              <tr>
                <td>{{ $ch->cadre->Lib_Cadre_FR ?? '-' }}</td>
                <td>{{ $ch->DT_AFF_Cadre ? \Carbon\Carbon::parse($ch->DT_AFF_Cadre)->format('d/m/Y') : '-' }}</td>
              </tr>
              @empty <tr><td colspan="2" style="text-align:center;color:var(--secondary);">-</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Diplômes & Absences -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
      <div class="card">
        <div class="card-header"><span class="card-title">Diplômes</span></div>
        <div class="card-body" style="padding:0;">
          <table>
            <thead><tr><th>Diplôme</th><th>Type</th><th>Date</th></tr></thead>
            <tbody>
              @forelse($employer->diplomes as $dip)
              <tr>
                <td>{{ $dip->LL_DIP ?? '-' }}</td>
                <td><span class="badge-pill badge-info">{{ $dip->TYPE_DIP }}</span></td>
                <td>{{ $dip->DT_DIP ? \Carbon\Carbon::parse($dip->DT_DIP)->format('d/m/Y') : '-' }}</td>
              </tr>
              @empty <tr><td colspan="3" style="text-align:center;color:var(--secondary);">-</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="card">
        <div class="card-header"><span class="card-title">Absences récentes</span></div>
        <div class="card-body" style="padding:0;">
          <table>
            <thead><tr><th>Début</th><th>Fin</th><th>Type</th><th>Justifié</th></tr></thead>
            <tbody>
              @forelse($employer->absences->take(5) as $abs)
              <tr>
                <td>{{ $abs->date_debut ? $abs->date_debut->format('d/m/Y') : '-' }}</td>
                <td>{{ $abs->date_fin ? $abs->date_fin->format('d/m/Y') : '-' }}</td>
                <td>{{ $abs->congee->type_congee ?? 'Absence' }}</td>
                <td>
                  <span class="badge-pill {{ $abs->is_justify ? 'badge-success' : 'badge-danger' }}">
                    {{ $abs->is_justify ? 'Oui' : 'Non' }}
                  </span>
                </td>
              </tr>
              @empty <tr><td colspan="4" style="text-align:center;color:var(--secondary);">-</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
