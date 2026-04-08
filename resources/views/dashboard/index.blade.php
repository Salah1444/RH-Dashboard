@extends('layouts.master')
@section('title', 'Tableau de Bord')
@section('page-title', 'Tableau de Bord')

@section('content')
<div class="page-header">
  <h1>Vue d'ensemble RH</h1>
  <div style="font-size:12px;color:var(--secondary);">
    <i class="fas fa-calendar-alt" style="margin-right:5px;"></i>
    {{ now()->isoFormat('dddd D MMMM YYYY') }}
  </div>
</div>

<!-- KPI CARDS -->
<div class="kpi-grid" style="grid-template-columns:repeat(5,1fr);">
  <div class="kpi-card primary">
    <div>
      <div class="kpi-label">Total Employés</div>
      <div class="kpi-value">{{ number_format($totalEmployes) }}</div>
      <div class="kpi-sub">Tous statuts</div>
    </div>
    <div class="kpi-icon"><i class="fas fa-users"></i></div>
  </div>
  <div class="kpi-card success">
    <div>
      <div class="kpi-label">Établissements</div>
      <div class="kpi-value">{{ $totalEtablissements }}</div>
      <div class="kpi-sub">Tous types</div>
    </div>
    <div class="kpi-icon"><i class="fas fa-school"></i></div>
  </div>
  <div class="kpi-card warning">
    <div>
      <div class="kpi-label">Absences (mois)</div>
      <div class="kpi-value">{{ $absencesMois }}</div>
      <div class="kpi-sub">{{ now()->isoFormat('MMMM YYYY') }}</div>
    </div>
    <div class="kpi-icon"><i class="fas fa-calendar-times"></i></div>
  </div>
  <div class="kpi-card info">
    <div>
      <div class="kpi-label">Congés en cours</div>
      <div class="kpi-value">{{ $congesEnCours }}</div>
      <div class="kpi-sub">Actifs aujourd'hui</div>
    </div>
    <div class="kpi-icon"><i class="fas fa-umbrella-beach"></i></div>
  </div>
  <div class="kpi-card danger">
    <div>
      <div class="kpi-label">Départs (retraite)</div>
      <div class="kpi-value">{{ $departsRetraite }}</div>
      <div class="kpi-sub">Prévus dans l'année</div>
    </div>
    <div class="kpi-icon"><i class="fas fa-sign-out-alt"></i></div>
  </div>
</div>

<!-- CHARTS ROW -->
<div style="display:grid;grid-template-columns:8fr 4fr;gap:20px;margin-bottom:24px;">
  <div class="card">
    <div class="card-header">
      <span class="card-title">Évolution des effectifs ({{ now()->year }})</span>
    </div>
    <div class="card-body">
      <div class="chart-container" style="height:260px;">
        <canvas id="chartEffectifs"></canvas>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><span class="card-title">Répartition par sexe</span></div>
    <div class="card-body">
      <div class="chart-container" style="height:200px;">
        <canvas id="chartSexe"></canvas>
      </div>
      <ul class="stat-list" style="margin-top:12px;">
        <li>
          <span><i class="fas fa-circle" style="color:#4e73df;font-size:10px;margin-right:6px;"></i>Hommes</span>
          <span style="font-weight:800;color:var(--primary);">{{ $hommes }} ({{ $totalEmployes > 0 ? round($hommes/$totalEmployes*100) : 0 }}%)</span>
        </li>
        <li>
          <span><i class="fas fa-circle" style="color:#e74a3b;font-size:10px;margin-right:6px;"></i>Femmes</span>
          <span style="font-weight:800;color:var(--danger);">{{ $femmes }} ({{ $totalEmployes > 0 ? round($femmes/$totalEmployes*100) : 0 }}%)</span>
        </li>
      </ul>
    </div>
  </div>
</div>

<!-- SECOND ROW -->
<div style="display:grid;grid-template-columns:4fr 8fr;gap:20px;margin-bottom:24px;">
  <div class="card">
    <div class="card-header"><span class="card-title">Répartition par cadre</span></div>
    <div class="card-body">
      <ul class="stat-list">
        @php $total_cadre = $repartitionCadre->sum('total') ?: 1; @endphp
        @foreach($repartitionCadre as $c)
        @php $pct = round($c->total / $total_cadre * 100); @endphp
        <li>
          <div style="flex:1;">
            <div style="display:flex;justify-content:space-between;margin-bottom:4px;">
              <span style="font-weight:600;">{{ $c->Lib_Cadre_FR ?? 'N/A' }}</span>
              <span style="font-weight:800;color:var(--primary);">{{ $pct }}%</span>
            </div>
            <div class="progress-bar-wrap">
              <div class="progress-bar-fill" style="width:{{ $pct }}%;background:var(--primary);"></div>
            </div>
          </div>
        </li>
        @endforeach
        @if($repartitionCadre->isEmpty())
          <li><span style="color:var(--secondary);">Aucune donnée</span></li>
        @endif
      </ul>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <span class="card-title">Dernières affectations</span>
      <a href="{{ route('affectations.index') }}" class="btn-sm">Voir tout</a>
    </div>
    <div class="card-body" style="padding:0;">
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th>Employé</th><th>CIN</th><th>Établissement</th><th>Fonction</th><th>Date</th><th>Mode</th>
            </tr>
          </thead>
          <tbody>
            @forelse($dernieresAffectations as $aff)
            @php
              $colors = ['#4e73df','#e74a3b','#1cc88a','#f6c23e','#858796'];
              $c = $colors[$loop->index % count($colors)];
              $initiales = $aff->employer ? strtoupper(substr($aff->employer->NOM_PRENOM_FR ?? '?', 0, 2)) : '??';
            @endphp
            <tr>
              <td>
                <div style="display:flex;align-items:center;">
                  <div class="avatar-sm" style="background:{{ $c }};">{{ $initiales }}</div>
                  {{ $aff->employer->NOM_PRENOM_FR ?? 'N/A' }}
                </div>
              </td>
              <td>{{ $aff->employer->CIN ?? '-' }}</td>
              <td>{{ $aff->etablisement->NOM_ETAB ?? '-' }}</td>
              <td>{{ $aff->fonction->LIB_FONCTION_FR ?? '-' }}</td>
              <td>{{ $aff->DT_AFF_POSTE ? $aff->DT_AFF_POSTE->format('d/m/Y') : '-' }}</td>
              <td><span class="badge-pill badge-primary">{{ $aff->Mode_Affectation ?? 'N/A' }}</span></td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:var(--secondary);">Aucune affectation</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- BOTTOM ROW -->
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:24px;">
  <!-- Absences récentes -->
  <div class="card">
    <div class="card-header"><span class="card-title">Absences récentes</span></div>
    <div class="card-body" style="padding-top:8px;">
      @forelse($absencesRecentes as $abs)
      <div style="display:flex;gap:12px;padding:10px 0;border-bottom:1px solid #f0f0f0;">
        <div style="width:32px;height:32px;border-radius:50%;background:{{ $abs->is_justify ? 'var(--success)' : 'var(--danger)' }};display:flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0;font-size:13px;">
          <i class="fas {{ $abs->is_justify ? 'fa-check' : 'fa-times' }}"></i>
        </div>
        <div style="flex:1;">
          <div style="font-size:12px;font-weight:700;color:var(--dark);">{{ $abs->employer->NOM_PRENOM_FR ?? 'N/A' }}</div>
          <div style="font-size:11px;color:var(--secondary);">{{ $abs->congee->type_congee ?? 'Absence' }}</div>
          <div style="font-size:11px;color:var(--secondary);">{{ $abs->date_debut ? $abs->date_debut->format('d/m/Y') : '-' }}</div>
        </div>
        <span class="badge-pill {{ $abs->is_justify ? 'badge-success' : 'badge-danger' }}" style="align-self:center;">
          {{ $abs->is_justify ? 'J' : 'NJ' }}
        </span>
      </div>
      @empty
      <p style="color:var(--secondary);font-size:13px;">Aucune absence récente</p>
      @endforelse
    </div>
  </div>

  <!-- Chart région -->
  <div class="card">
    <div class="card-header"><span class="card-title">Répartition par région</span></div>
    <div class="card-body">
      <div class="chart-container" style="height:220px;">
        <canvas id="chartRegion"></canvas>
      </div>
    </div>
  </div>

  <!-- Indicateurs clés -->
  <div class="card">
    <div class="card-header"><span class="card-title">Indicateurs clés</span></div>
    <div class="card-body" style="padding-top:8px;">
      @php
      $indicators = [
        ['icon'=>'fa-graduation-cap','bg'=>'#eef2ff','color'=>'var(--primary)','label'=>'Diplômés (Scolaire)','val'=>$diplomesBacPlus5],
        ['icon'=>'fa-baby','bg'=>'#d4edda','color'=>'var(--success)','label'=>'Enfants à charge','val'=>$enfantsTotal],
        ['icon'=>'fa-ring','bg'=>'#fff3cd','color'=>'var(--warning)','label'=>'Employés mariés','val'=>$employes_maries],
        ['icon'=>'fa-layer-group','bg'=>'#d1ecf1','color'=>'var(--info)','label'=>'Grades distincts','val'=>$gradesDistincts],
        ['icon'=>'fa-clock','bg'=>'#f8d7da','color'=>'var(--danger)','label'=>'Retraite < 2 ans','val'=>$retraite2ans],
      ];
      @endphp
      @foreach($indicators as $ind)
      <div style="display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid #f0f0f0;">
        <div style="width:38px;height:38px;border-radius:8px;background:{{ $ind['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
          <i class="fas {{ $ind['icon'] }}" style="color:{{ $ind['color'] }};font-size:16px;"></i>
        </div>
        <div>
          <div style="font-size:11px;color:var(--secondary);font-weight:600;">{{ $ind['label'] }}</div>
          <div style="font-size:18px;font-weight:800;color:var(--dark);">{{ number_format($ind['val']) }}</div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
// Effectifs
const ctx1 = document.getElementById('chartEffectifs').getContext('2d');
new Chart(ctx1, {
  type: 'line',
  data: {
    labels: @json($moisLabels),
    datasets: [{
      label: 'Effectifs',
      data: @json($effectifsData),
      borderColor: '#4e73df', backgroundColor: 'rgba(78,115,223,.08)',
      fill: true, tension: 0.4, pointBackgroundColor: '#4e73df', pointRadius: 4, borderWidth: 2
    }]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
      y: { grid: { color: '#f0f0f7' }, ticks: { font: { family: 'Nunito', size: 11 } } },
      x: { grid: { display: false }, ticks: { font: { family: 'Nunito', size: 11 } } }
    }
  }
});

// Sexe
const ctx2 = document.getElementById('chartSexe').getContext('2d');
new Chart(ctx2, {
  type: 'doughnut',
  data: {
    labels: ['Hommes', 'Femmes'],
    datasets: [{ data: [{{ $hommes }}, {{ $femmes }}], backgroundColor: ['#4e73df','#e74a3b'], borderWidth: 2, borderColor: '#fff' }]
  },
  options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, cutout: '70%' }
});

// Régions
const ctx3 = document.getElementById('chartRegion').getContext('2d');
new Chart(ctx3, {
  type: 'bar',
  data: {
    labels: @json($parRegion->pluck('LIB_REGION_FR')),
    datasets: [{
      label: 'Employés',
      data: @json($parRegion->pluck('total')),
      backgroundColor: ['#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b','#858796','#5a5c69'],
      borderRadius: 4, borderWidth: 0
    }]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
      y: { grid: { color: '#f0f0f7' }, ticks: { font: { family: 'Nunito', size: 11 } } },
      x: { grid: { display: false }, ticks: { font: { family: 'Nunito', size: 10 }, maxRotation: 45 } }
    }
  }
});
</script>
@endpush
