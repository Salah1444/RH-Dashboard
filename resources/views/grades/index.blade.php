@extends('layouts.master')
@section('title','Référentiels RH')
@section('page-title','Gestion RH')

@section('content')

<div class="page-header">
  <h1>Référentiels RH</h1>
</div>

<hr style="margin:25px 0;">

{{-- KPI --}}
<div class="kpi-grid" style="grid-template-columns:repeat(3,1fr);">
  <div class="kpi-card primary">
    <div><div class="kpi-label">Grades</div><div class="kpi-value">{{ $totalGrades }}</div></div>
    <div class="kpi-icon"><i class="fas fa-award"></i></div>
  </div>
  <div class="kpi-card success">
    <div><div class="kpi-label">Cadres</div><div class="kpi-value">{{ $totalCadres }}</div></div>
    <div class="kpi-icon"><i class="fas fa-user-tag"></i></div>
  </div>
  <div class="kpi-card info">
    <div><div class="kpi-label">Échelons</div><div class="kpi-value">{{ $totalEch }}</div></div>
    <div class="kpi-icon"><i class="fas fa-layer-group"></i></div>
  </div>
</div>

<hr style="margin:25px 0;">

{{-- ===== IMPORTS RÉFÉRENTIELS ===== --}}
<div class="page-header d-flex justify-content-between align-items-center" style="margin-bottom:12px;">
  <h2 style="font-size:18px;font-weight:700;margin:0;">Imports Excel — Référentiels</h2>
</div>

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:30px;">

  {{-- IMPORT GRADES --}}
  <div class="card" style="margin-bottom:0;">
    <div class="card-header" style="cursor:pointer;user-select:none;" onclick="toggleExcelPanel(this)">
      <span class="card-title">
        <i class="fas fa-file-excel" style="color:#1d6f42;margin-right:6px;"></i>
        Importer Grades
      </span>
      <span style="font-size:12px;color:var(--secondary);"><i class="fas fa-chevron-down"></i></span>
    </div>
    <div class="excel-panel" style="display:none;">
      <div class="card-body" style="padding:14px;">
        <div style="margin-bottom:10px;background:#f8f9fc;border:1px solid #e3e6f0;border-radius:8px;padding:12px;">
          <div style="font-weight:700;font-size:12px;margin-bottom:6px;">
            <span style="background:#1d6f42;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:10px;margin-right:5px;">1</span>
            Télécharger le modèle
          </div>
          <a href="{{ route('grades.template') }}" class="btn btn-sm" style="background:#1d6f42;color:#fff;font-size:11px;">
            <i class="fas fa-download"></i> Modèle Excel
          </a>
        </div>
        <div style="background:#f8f9fc;border:1px solid #e3e6f0;border-radius:8px;padding:12px;">
          <div style="font-weight:700;font-size:12px;margin-bottom:6px;">
            <span style="background:#4e73df;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:10px;margin-right:5px;">2</span>
            Importer votre fichier
          </div>
          <form method="POST" action="{{ route('grades.import') }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="excel_file" class="form-control form-control-sm mb-2" accept=".xlsx,.xls,.csv" required>
            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Confirmer l\'importation ?')">
              <i class="fas fa-upload"></i> Importer
            </button>
          </form>
          <p style="font-size:10px;color:var(--secondary);margin:6px 0 0 0;"><i class="fas fa-info-circle"></i> Seules les nouvelles entrées seront ajoutées.</p>
        </div>
      </div>
    </div>
  </div>

  {{-- IMPORT CADRES --}}
  <div class="card" style="margin-bottom:0;">
    <div class="card-header" style="cursor:pointer;user-select:none;" onclick="toggleExcelPanel(this)">
      <span class="card-title">
        <i class="fas fa-file-excel" style="color:#1d6f42;margin-right:6px;"></i>
        Importer Cadres
      </span>
      <span style="font-size:12px;color:var(--secondary);"><i class="fas fa-chevron-down"></i></span>
    </div>
    <div class="excel-panel" style="display:none;">
      <div class="card-body" style="padding:14px;">
        <div style="margin-bottom:10px;background:#f8f9fc;border:1px solid #e3e6f0;border-radius:8px;padding:12px;">
          <div style="font-weight:700;font-size:12px;margin-bottom:6px;">
            <span style="background:#1d6f42;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:10px;margin-right:5px;">1</span>
            Télécharger le modèle
          </div>
          <a href="{{ route('cadres.template') }}" class="btn btn-sm" style="background:#1d6f42;color:#fff;font-size:11px;">
            <i class="fas fa-download"></i> Modèle Excel
          </a>
        </div>
        <div style="background:#f8f9fc;border:1px solid #e3e6f0;border-radius:8px;padding:12px;">
          <div style="font-weight:700;font-size:12px;margin-bottom:6px;">
            <span style="background:#4e73df;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:10px;margin-right:5px;">2</span>
            Importer votre fichier
          </div>
          <form method="POST" action="{{ route('cadres.import') }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="excel_file" class="form-control form-control-sm mb-2" accept=".xlsx,.xls,.csv" required>
            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Confirmer l\'importation ?')">
              <i class="fas fa-upload"></i> Importer
            </button>
          </form>
          <p style="font-size:10px;color:var(--secondary);margin:6px 0 0 0;"><i class="fas fa-info-circle"></i> Seules les nouvelles entrées seront ajoutées.</p>
        </div>
      </div>
    </div>
  </div>

  {{-- IMPORT ÉCHELONS --}}
  <div class="card" style="margin-bottom:0;">
    <div class="card-header" style="cursor:pointer;user-select:none;" onclick="toggleExcelPanel(this)">
      <span class="card-title">
        <i class="fas fa-file-excel" style="color:#1d6f42;margin-right:6px;"></i>
        Importer Échelons
      </span>
      <span style="font-size:12px;color:var(--secondary);"><i class="fas fa-chevron-down"></i></span>
    </div>
    <div class="excel-panel" style="display:none;">
      <div class="card-body" style="padding:14px;">
        <div style="margin-bottom:10px;background:#f8f9fc;border:1px solid #e3e6f0;border-radius:8px;padding:12px;">
          <div style="font-weight:700;font-size:12px;margin-bottom:6px;">
            <span style="background:#1d6f42;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:10px;margin-right:5px;">1</span>
            Télécharger le modèle
          </div>
          <a href="{{ route('echelons.template') }}" class="btn btn-sm" style="background:#1d6f42;color:#fff;font-size:11px;">
            <i class="fas fa-download"></i> Modèle Excel
          </a>
        </div>
        <div style="background:#f8f9fc;border:1px solid #e3e6f0;border-radius:8px;padding:12px;">
          <div style="font-weight:700;font-size:12px;margin-bottom:6px;">
            <span style="background:#4e73df;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:10px;margin-right:5px;">2</span>
            Importer votre fichier
          </div>
          <form method="POST" action="{{ route('echelons.import') }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="excel_file" class="form-control form-control-sm mb-2" accept=".xlsx,.xls,.csv" required>
            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Confirmer l\'importation ?')">
              <i class="fas fa-upload"></i> Importer
            </button>
          </form>
          <p style="font-size:10px;color:var(--secondary);margin:6px 0 0 0;"><i class="fas fa-info-circle"></i> Seules les nouvelles entrées seront ajoutées.</p>
        </div>
      </div>
    </div>
  </div>

</div>

{{-- ===== RÉFÉRENTIELS ===== --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">

  {{-- GRADES --}}
  <div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span class="card-title font-weight-bold"><i class="fas fa-award mr-1"></i> Grades</span>
      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAddGrade">
        <i class="fas fa-plus"></i>
      </button>
    </div>
    <div class="card-body p-0">
      <table class="table table-sm table-hover mb-0">
        <thead class="thead-light"><tr><th>Code</th><th>Libellé</th><th></th></tr></thead>
        <tbody>
        @forelse($grades as $gr)
          <tr>
            <td><span class="badge badge-primary">{{ $gr->GRADE }}</span></td>
            <td>{{ $gr->Lib_grade_FR }}</td>
            <td class="text-right">
              <button class="btn btn-sm btn-warning" data-toggle="modal"
                data-target="#modalEditGrade{{ $gr->id_grade }}"><i class="fas fa-edit"></i></button>
              <form action="{{ route('grades.destroy', $gr->id_grade) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Supprimer ce grade ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="3" class="text-center text-muted py-3">Aucun grade.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    @if($grades->hasPages()) <div class="card-footer">{{ $grades->links() }}</div> @endif
  </div>

  {{-- CADRES --}}
  <div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span class="card-title font-weight-bold"><i class="fas fa-user-tag mr-1"></i> Cadres</span>
      <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAddCadre">
        <i class="fas fa-plus"></i>
      </button>
    </div>
    <div class="card-body p-0">
      <table class="table table-sm table-hover mb-0">
        <thead class="thead-light"><tr><th>Code</th><th>Libellé</th><th></th></tr></thead>
        <tbody>
        @forelse($cadres as $cd)
          <tr>
            <td><span class="badge badge-success">{{ $cd->CADRE }}</span></td>
            <td>{{ $cd->Lib_Cadre_FR }}</td>
            <td class="text-right">
              <button class="btn btn-sm btn-warning" data-toggle="modal"
                data-target="#modalEditCadre{{ $cd->id_cadre }}"><i class="fas fa-edit"></i></button>
              <form action="{{ route('cadres.destroy', $cd->id_cadre) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Supprimer ce cadre ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="3" class="text-center text-muted py-3">Aucun cadre.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    @if($cadres->hasPages()) <div class="card-footer">{{ $cadres->links() }}</div> @endif
  </div>

  {{-- ÉCHELONS --}}
  <div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span class="card-title font-weight-bold"><i class="fas fa-layer-group mr-1"></i> Échelons</span>
      <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalAddEchelon">
        <i class="fas fa-plus"></i>
      </button>
    </div>
    <div class="card-body p-0">
      <table class="table table-sm table-hover mb-0">
        <thead class="thead-light"><tr><th>Code</th><th>ELO</th><th></th></tr></thead>
        <tbody>
        @forelse($echelons as $ech)
          <tr>
            <td><span class="badge badge-info">{{ $ech->COD_ECH }}</span></td>
            <td>{{ $ech->COD_ELO }}</td>
            <td class="text-right">
              <button class="btn btn-sm btn-warning" data-toggle="modal"
                data-target="#modalEditEchelon{{ $ech->id_ech }}"><i class="fas fa-edit"></i></button>
              <form action="{{ route('echelons.destroy', $ech->id_ech) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Supprimer cet échelon ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="3" class="text-center text-muted py-3">Aucun échelon.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    @if($echelons->hasPages()) <div class="card-footer">{{ $echelons->links() }}</div> @endif
  </div>

</div>

<hr style="margin:35px 0;">

{{-- ===== HISTORIQUES ===== --}}
<div class="page-header">
  <h1>Historiques</h1>
</div>

<div class="page-header d-flex justify-content-between align-items-center" style="margin-bottom:12px;">
  <h2 style="font-size:18px;font-weight:700;margin:0;">Imports Excel — Historiques</h2>
</div>

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:30px;">

  {{-- IMPORT HISTORIQUE GRADES --}}
  <div class="card" style="margin-bottom:0;">
    <div class="card-header" style="cursor:pointer;user-select:none;" onclick="toggleExcelPanel(this)">
      <span class="card-title">
        <i class="fas fa-file-excel" style="color:#1d6f42;margin-right:6px;"></i>
        Importer Histo. Grades
      </span>
      <span style="font-size:12px;color:var(--secondary);"><i class="fas fa-chevron-down"></i></span>
    </div>
    <div class="excel-panel" style="display:none;">
      <div class="card-body" style="padding:14px;">
        <div style="margin-bottom:10px;background:#f8f9fc;border:1px solid #e3e6f0;border-radius:8px;padding:12px;">
          <div style="font-weight:700;font-size:12px;margin-bottom:4px;">
            <span style="background:#1d6f42;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:10px;margin-right:5px;">1</span>
            Télécharger le modèle
          </div>
          <p style="font-size:10px;color:var(--secondary);margin:0 0 6px 0;">Colonnes : code_agent, id_grade, anc_grade, dat_eff_gr, mod_av_grade, libelle_grade</p>
          <a href="{{ route('grades.history.template') }}" class="btn btn-sm" style="background:#1d6f42;color:#fff;font-size:11px;">
            <i class="fas fa-download"></i> Modèle Excel
          </a>
        </div>
        <div style="background:#f8f9fc;border:1px solid #e3e6f0;border-radius:8px;padding:12px;">
          <div style="font-weight:700;font-size:12px;margin-bottom:6px;">
            <span style="background:#4e73df;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:10px;margin-right:5px;">2</span>
            Importer votre fichier
          </div>
          <form method="POST" action="{{ route('grades.history.import') }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="excel_file" class="form-control form-control-sm mb-2" accept=".xlsx,.xls,.csv" required>
            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Confirmer l\'importation ?')">
              <i class="fas fa-upload"></i> Importer
            </button>
          </form>
          <p style="font-size:10px;color:var(--secondary);margin:6px 0 0 0;"><i class="fas fa-info-circle"></i> Seules les nouvelles entrées seront ajoutées.</p>
        </div>
      </div>
    </div>
  </div>

  {{-- IMPORT HISTORIQUE CADRES --}}
  <div class="card" style="margin-bottom:0;">
    <div class="card-header" style="cursor:pointer;user-select:none;" onclick="toggleExcelPanel(this)">
      <span class="card-title">
        <i class="fas fa-file-excel" style="color:#1d6f42;margin-right:6px;"></i>
        Importer Histo. Cadres
      </span>
      <span style="font-size:12px;color:var(--secondary);"><i class="fas fa-chevron-down"></i></span>
    </div>
    <div class="excel-panel" style="display:none;">
      <div class="card-body" style="padding:14px;">
        <div style="margin-bottom:10px;background:#f8f9fc;border:1px solid #e3e6f0;border-radius:8px;padding:12px;">
          <div style="font-weight:700;font-size:12px;margin-bottom:4px;">
            <span style="background:#1d6f42;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:10px;margin-right:5px;">1</span>
            Télécharger le modèle
          </div>
          <p style="font-size:10px;color:var(--secondary);margin:0 0 6px 0;">Colonnes : code_agent, id_cadre, anc_adm, dt_aff_cadre</p>
          <a href="{{ route('cadres.history.template') }}" class="btn btn-sm" style="background:#1d6f42;color:#fff;font-size:11px;">
            <i class="fas fa-download"></i> Modèle Excel
          </a>
        </div>
        <div style="background:#f8f9fc;border:1px solid #e3e6f0;border-radius:8px;padding:12px;">
          <div style="font-weight:700;font-size:12px;margin-bottom:6px;">
            <span style="background:#4e73df;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:10px;margin-right:5px;">2</span>
            Importer votre fichier
          </div>
          <form method="POST" action="{{ route('cadres.history.import') }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="excel_file" class="form-control form-control-sm mb-2" accept=".xlsx,.xls,.csv" required>
            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Confirmer l\'importation ?')">
              <i class="fas fa-upload"></i> Importer
            </button>
          </form>
          <p style="font-size:10px;color:var(--secondary);margin:6px 0 0 0;"><i class="fas fa-info-circle"></i> Seules les nouvelles entrées seront ajoutées.</p>
        </div>
      </div>
    </div>
  </div>

  {{-- IMPORT HISTORIQUE ÉCHELONS --}}
  <div class="card" style="margin-bottom:0;">
    <div class="card-header" style="cursor:pointer;user-select:none;" onclick="toggleExcelPanel(this)">
      <span class="card-title">
        <i class="fas fa-file-excel" style="color:#1d6f42;margin-right:6px;"></i>
        Importer Histo. Échelons
      </span>
      <span style="font-size:12px;color:var(--secondary);"><i class="fas fa-chevron-down"></i></span>
    </div>
    <div class="excel-panel" style="display:none;">
      <div class="card-body" style="padding:14px;">
        <div style="margin-bottom:10px;background:#f8f9fc;border:1px solid #e3e6f0;border-radius:8px;padding:12px;">
          <div style="font-weight:700;font-size:12px;margin-bottom:4px;">
            <span style="background:#1d6f42;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:10px;margin-right:5px;">1</span>
            Télécharger le modèle
          </div>
          <p style="font-size:10px;color:var(--secondary);margin:0 0 6px 0;">Colonnes : code_agent, id_ech, indice, dat_eff_elo</p>
          <a href="{{ route('echelons.history.template') }}" class="btn btn-sm" style="background:#1d6f42;color:#fff;font-size:11px;">
            <i class="fas fa-download"></i> Modèle Excel
          </a>
        </div>
        <div style="background:#f8f9fc;border:1px solid #e3e6f0;border-radius:8px;padding:12px;">
          <div style="font-weight:700;font-size:12px;margin-bottom:6px;">
            <span style="background:#4e73df;color:#fff;border-radius:50%;width:18px;height:18px;display:inline-flex;align-items:center;justify-content:center;font-size:10px;margin-right:5px;">2</span>
            Importer votre fichier
          </div>
          <form method="POST" action="{{ route('echelons.history.import') }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="excel_file" class="form-control form-control-sm mb-2" accept=".xlsx,.xls,.csv" required>
            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Confirmer l\'importation ?')">
              <i class="fas fa-upload"></i> Importer
            </button>
          </form>
          <p style="font-size:10px;color:var(--secondary);margin:6px 0 0 0;"><i class="fas fa-info-circle"></i> Seules les nouvelles entrées seront ajoutées.</p>
        </div>
      </div>
    </div>
  </div>

</div>

<hr style="margin:25px 0;">

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">

  {{-- HISTO GRADE --}}
  <div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span class="font-weight-bold"><i class="fas fa-history mr-1"></i> Historique Grades</span>
      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAddGradeHistory">
        <i class="fas fa-plus"></i>
      </button>
    </div>
    <div class="card-body p-0">
      <table class="table table-sm table-hover mb-0">
        <thead class="thead-light"><tr><th>Employé</th><th>Grade</th><th>Date</th><th></th></tr></thead>
        <tbody>
        @forelse($gradeHistories as $h)
          <tr>
            <td class="small">{{ $h->employer->NOM_PRENOM_FR ?? '-' }}</td>
            <td><span class="badge badge-primary">{{ $h->grade->Lib_grade_FR ?? '-' }}</span></td>
            <td class="small">{{ $h->DAT_EFF_GR?->format('d/m/Y') ?? '-' }}</td>
            
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted py-3">Aucun historique.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    @if($gradeHistories->hasPages()) <div class="card-footer">{{ $gradeHistories->links() }}</div> @endif
  </div>

  {{-- HISTO CADRE --}}
  <div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span class="font-weight-bold"><i class="fas fa-history mr-1"></i> Historique Cadres</span>
      <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAddCadreHistory">
        <i class="fas fa-plus"></i>
      </button>
    </div>
    <div class="card-body p-0">
      <table class="table table-sm table-hover mb-0">
        <thead class="thead-light"><tr><th>Employé</th><th>Cadre</th><th>Date</th><th></th></tr></thead>
        <tbody>
        @forelse($cadreHistories as $h)
          <tr>
            <td class="small">{{ $h->employer->NOM_PRENOM_FR ?? '-' }}</td>
            <td><span class="badge badge-success">{{ $h->cadre->Lib_Cadre_FR ?? '-' }}</span></td>
            <td class="small">{{ $h->DT_AFF_Cadre?->format('d/m/Y') ?? '-' }}</td>
            
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted py-3">Aucun historique.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    @if($cadreHistories->hasPages()) <div class="card-footer">{{ $cadreHistories->links() }}</div> @endif
  </div>

  {{-- HISTO ÉCHELON --}}
  <div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span class="font-weight-bold"><i class="fas fa-history mr-1"></i> Historique Échelons</span>
      <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalAddEchelonHistory">
        <i class="fas fa-plus"></i>
      </button>
    </div>
    <div class="card-body p-0">
      <table class="table table-sm table-hover mb-0">
        <thead class="thead-light"><tr><th>Employé</th><th>Échelon</th><th>Date</th><th></th></tr></thead>
        <tbody>
        @forelse($echelonHistories as $h)
          <tr>
            <td class="small">{{ $h->employer->NOM_PRENOM_FR ?? '-' }}</td>
            <td><span class="badge badge-info">{{ $h->echelon->COD_ECH ?? '-' }}</span></td>
            <td class="small">{{ $h->DAT_EFF_ELO?->format('d/m/Y') ?? '-' }}</td>
            
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted py-3">Aucun historique.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    @if($echelonHistories->hasPages()) <div class="card-footer">{{ $echelonHistories->links() }}</div> @endif
  </div>

</div>

{{-- ================================================================
     MODALS EDIT — hors des tableaux (fix HTML invalide <div> dans <tbody>)
================================================================ --}}

{{-- Edit Grade modals --}}
@foreach($grades as $gr)
<div class="modal fade" id="modalEditGrade{{ $gr->id_grade }}" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Modifier grade</h5>
      <button type="button" class="close" data-dismiss="modal">&times;</button></div>
    <form action="{{ route('grades.update', $gr->id_grade) }}" method="POST">
      @csrf @method('PUT')
      <div class="modal-body">
        <div class="form-group"><label>Code</label>
          <input type="text" name="GRADE" class="form-control" value="{{ $gr->GRADE }}" required></div>
        <div class="form-group"><label>Libellé (FR)</label>
          <input type="text" name="Lib_grade_FR" class="form-control" value="{{ $gr->Lib_grade_FR }}" required></div>
        <div class="form-group"><label>الاسم (AR)</label>
          <input type="text" name="Lib_grade_AR" class="form-control text-right" dir="rtl" value="{{ $gr->Lib_grade_AR }}"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-warning">Enregistrer</button>
      </div>
    </form>
  </div></div>
</div>
@endforeach

{{-- Edit Cadre modals --}}
@foreach($cadres as $cd)
<div class="modal fade" id="modalEditCadre{{ $cd->id_cadre }}" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Modifier cadre</h5>
      <button type="button" class="close" data-dismiss="modal">&times;</button></div>
    <form action="{{ route('cadres.update', $cd->id_cadre) }}" method="POST">
      @csrf @method('PUT')
      <div class="modal-body">
        <div class="form-group"><label>Code</label>
          <input type="text" name="CADRE" class="form-control" value="{{ $cd->CADRE }}" required></div>
        <div class="form-group"><label>Libellé (FR)</label>
          <input type="text" name="Lib_Cadre_FR" class="form-control" value="{{ $cd->Lib_Cadre_FR }}" required></div>
        <div class="form-group"><label>الاسم (AR)</label>
          <input type="text" name="Lib_cadre_AR" class="form-control text-right" dir="rtl" value="{{ $cd->Lib_cadre_AR }}"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-warning">Enregistrer</button>
      </div>
    </form>
  </div></div>
</div>
@endforeach

{{-- Edit Echelon modals --}}
@foreach($echelons as $ech)
<div class="modal fade" id="modalEditEchelon{{ $ech->id_ech }}" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Modifier échelon</h5>
      <button type="button" class="close" data-dismiss="modal">&times;</button></div>
    <form action="{{ route('echelons.update', $ech->id_ech) }}" method="POST">
      @csrf @method('PUT')
      <div class="modal-body">
        <div class="form-group"><label>COD_ECH</label>
          <input type="text" name="COD_ECH" class="form-control" value="{{ $ech->COD_ECH }}" required></div>
        <div class="form-group"><label>COD_ELO</label>
          <input type="text" name="COD_ELO" class="form-control" value="{{ $ech->COD_ELO }}"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-warning">Enregistrer</button>
      </div>
    </form>
  </div></div>
</div>
@endforeach


{{-- ================================================================
     ADD MODALS
================================================================ --}}

{{-- Add Grade --}}
<div class="modal fade" id="modalAddGrade" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title"><i class="fas fa-award mr-1"></i> Nouveau grade</h5>
      <button type="button" class="close" data-dismiss="modal">&times;</button></div>
    <form action="{{ route('grades.store') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-group"><label>Code <span class="text-danger">*</span></label>
          <input type="text" name="GRADE" class="form-control" placeholder="PES" required></div>
        <div class="form-group"><label>Libellé (FR) <span class="text-danger">*</span></label>
          <input type="text" name="Lib_grade_FR" class="form-control" placeholder="Professeur Enseignement Secondaire" required></div>
        <div class="form-group"><label>الاسم (AR)</label>
          <input type="text" name="Lib_grade_AR" class="form-control text-right" dir="rtl"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary">Créer</button>
      </div>
    </form>
  </div></div>
</div>

{{-- Add Cadre --}}
<div class="modal fade" id="modalAddCadre" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title"><i class="fas fa-user-tag mr-1"></i> Nouveau cadre</h5>
      <button type="button" class="close" data-dismiss="modal">&times;</button></div>
    <form action="{{ route('cadres.store') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-group"><label>Code <span class="text-danger">*</span></label>
          <input type="text" name="CADRE" class="form-control" required></div>
        <div class="form-group"><label>Libellé (FR) <span class="text-danger">*</span></label>
          <input type="text" name="Lib_Cadre_FR" class="form-control" required></div>
        <div class="form-group"><label>الاسم (AR)</label>
          <input type="text" name="Lib_cadre_AR" class="form-control text-right" dir="rtl"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-success">Créer</button>
      </div>
    </form>
  </div></div>
</div>

{{-- Add Echelon --}}
<div class="modal fade" id="modalAddEchelon" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title"><i class="fas fa-layer-group mr-1"></i> Nouvel échelon</h5>
      <button type="button" class="close" data-dismiss="modal">&times;</button></div>
    <form action="{{ route('echelons.store') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-group"><label>COD_ECH <span class="text-danger">*</span></label>
          <input type="text" name="COD_ECH" class="form-control" required></div>
        <div class="form-group"><label>COD_ELO</label>
          <input type="text" name="COD_ELO" class="form-control"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-info">Créer</button>
      </div>
    </form>
  </div></div>
</div>

{{-- Add Grade History --}}
<div class="modal fade" id="modalAddGradeHistory" tabindex="-1">
  <div class="modal-dialog modal-lg"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title"><i class="fas fa-history mr-1"></i> Ajouter historique grade</h5>
      <button type="button" class="close" data-dismiss="modal">&times;</button></div>
    <form action="{{ route('grades.history.store') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group col-md-6"><label>Employé <span class="text-danger">*</span></label>
            <select name="code_agent" class="form-control" required>
              <option value="">— Sélectionner —</option>
              @foreach($employes as $emp)
                <option value="{{ $emp->COD_AG }}">{{ $emp->NOM_PRENOM_FR }}</option>
              @endforeach
            </select></div>
          <div class="form-group col-md-6"><label>Grade <span class="text-danger">*</span></label>
            <select name="id_grade" class="form-control" required>
              <option value="">— Sélectionner —</option>
              @foreach($allGrades as $g)
                <option value="{{ $g->id_grade }}">{{ $g->Lib_grade_FR }}</option>
              @endforeach
            </select></div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4"><label>Ancienneté grade</label>
            <input type="text" name="ANC_GRADE" class="form-control" placeholder="Ex: 5 ans"></div>
          <div class="form-group col-md-4"><label>Date effet</label>
            <input type="date" name="DAT_EFF_GR" class="form-control"></div>
          <div class="form-group col-md-4"><label>Mode avancement</label>
            <input type="text" name="MOD_AV_GRADE" class="form-control" placeholder="Choix / Ancienneté"></div>
        </div>
        <div class="form-group"><label>Libellé grade</label>
          <input type="text" name="LIBELLE_GRADE" class="form-control"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
      </div>
    </form>
  </div></div>
</div>

{{-- Add Cadre History --}}
<div class="modal fade" id="modalAddCadreHistory" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title"><i class="fas fa-history mr-1"></i> Ajouter historique cadre</h5>
      <button type="button" class="close" data-dismiss="modal">&times;</button></div>
    <form action="{{ route('cadres.history.store') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-group"><label>Employé <span class="text-danger">*</span></label>
          <select name="code_agent" class="form-control" required>
            <option value="">— Sélectionner —</option>
            @foreach($employes as $emp)
              <option value="{{ $emp->COD_AG }}">{{ $emp->NOM_PRENOM_FR }}</option>
            @endforeach
          </select></div>
        <div class="form-group"><label>Cadre <span class="text-danger">*</span></label>
          <select name="id_cadre" class="form-control" required>
            <option value="">— Sélectionner —</option>
            @foreach($allCadres as $c)
              <option value="{{ $c->id_cadre }}">{{ $c->Lib_Cadre_FR }}</option>
            @endforeach
          </select></div>
        <div class="form-row">
          <div class="form-group col-md-6"><label>ANC_ADM</label>
            <input type="text" name="ANC_ADM" class="form-control"></div>
          <div class="form-group col-md-6"><label>Date affectation cadre</label>
            <input type="date" name="DT_AFF_Cadre" class="form-control"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-success">Enregistrer</button>
      </div>
    </form>
  </div></div>
</div>

{{-- Add Echelon History --}}
<div class="modal fade" id="modalAddEchelonHistory" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title"><i class="fas fa-history mr-1"></i> Ajouter historique échelon</h5>
      <button type="button" class="close" data-dismiss="modal">&times;</button></div>
    <form action="{{ route('echelons.history.store') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-group"><label>Employé <span class="text-danger">*</span></label>
          <select name="code_agent" class="form-control" required>
            <option value="">— Sélectionner —</option>
            @foreach($employes as $emp)
              <option value="{{ $emp->COD_AG }}">{{ $emp->NOM_PRENOM_FR }}</option>
            @endforeach
          </select></div>
        <div class="form-group"><label>Échelon <span class="text-danger">*</span></label>
          <select name="id_ech" class="form-control" required>
            <option value="">— Sélectionner —</option>
            @foreach($allEchelons as $e)
              <option value="{{ $e->id_ech }}">{{ $e->COD_ECH }}</option>
            @endforeach
          </select></div>
        <div class="form-row">
          <div class="form-group col-md-6"><label>Indice</label>
            <input type="text" name="INDICE" class="form-control"></div>
          <div class="form-group col-md-6"><label>Date effet</label>
            <input type="date" name="DAT_EFF_ELO" class="form-control"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-info">Enregistrer</button>
      </div>
    </form>
  </div></div>
</div>

<script>
function toggleExcelPanel(header) {
    const panel   = header.closest('.card').querySelector('.excel-panel');
    const chevron = header.querySelector('.fas');
    const isCurrentlyHidden = panel.style.display === 'none' || panel.style.display === '';

    panel.style.display = isCurrentlyHidden ? 'block' : 'none';

    if (chevron) {
        if (isCurrentlyHidden) {
            chevron.classList.remove('fa-chevron-down');
            chevron.classList.add('fa-chevron-up');
        } else {
            chevron.classList.remove('fa-chevron-up');
            chevron.classList.add('fa-chevron-down');
        }
    }
}

document.addEventListener('DOMContentLoaded', function () {
    @if(session('success') || session('error') || $errors->any())
        document.querySelectorAll('.excel-panel').forEach(p => {
            p.style.display = 'block';
            const chevron = p.closest('.card').querySelector('.card-header .fas');
            if (chevron) {
                chevron.classList.remove('fa-chevron-down');
                chevron.classList.add('fa-chevron-up');
            }
        });
    @endif
});
</script>

@endsection