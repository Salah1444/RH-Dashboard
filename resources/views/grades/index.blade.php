@extends('layouts.master')
@section('title','Grades & Cadres')
@section('page-title','Grades, Cadres & Échelons')

@section('content')
<div class="page-header">
  <h1>Référentiels RH</h1>
</div>


@if(session('error'))
  <div style="background:#f8d7da;border:1px solid #f5c6cb;color:#721c24;padding:12px 16px;border-radius:6px;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
  </div>
@endif

<!-- Import Excel Grades -->
<div class="card" style="margin-bottom:12px;">
  <div class="card-header" style="cursor:pointer;" onclick="this.nextElementSibling.style.display = this.nextElementSibling.style.display==='none'?'block':'none'">
    <span class="card-title"><i class="fas fa-file-excel" style="color:#1d6f42;margin-right:6px;"></i>Importer des <strong>Grades</strong> via Excel</span>
    <span style="font-size:12px;color:var(--secondary);">▼ Cliquer</span>
  </div>
  <div style="display:none;">
    <div class="card-body" style="padding:16px;display:flex;gap:16px;flex-wrap:wrap;">
      <a href="{{ route('grades.template') }}" class="btn btn-primary" style="background:#1d6f42;border-color:#1d6f42;font-size:12px;align-self:flex-start;">
        <i class="fas fa-download"></i> Modèle Grades
      </a>
      <form method="POST" action="{{ route('grades.import') }}" enctype="multipart/form-data" style="display:flex;gap:10px;align-items:flex-end;flex:1;">
        @csrf
        <div class="form-group" style="margin:0;flex:1;">
          <label class="form-label" style="font-size:12px;">Fichier Excel (.xlsx, .xls, .csv)</label>
          <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv" required style="font-size:12px;">
        </div>
        <button type="submit" class="btn btn-primary" style="font-size:12px;padding:6px 14px;" onclick="return confirm('Importer les grades ?')">
          <i class="fas fa-upload"></i> Importer
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Import Excel Cadres -->
<div class="card" style="margin-bottom:12px;">
  <div class="card-header" style="cursor:pointer;" onclick="this.nextElementSibling.style.display = this.nextElementSibling.style.display==='none'?'block':'none'">
    <span class="card-title"><i class="fas fa-file-excel" style="color:#1d6f42;margin-right:6px;"></i>Importer des <strong>Cadres</strong> via Excel</span>
    <span style="font-size:12px;color:var(--secondary);">▼ Cliquer</span>
  </div>
  <div style="display:none;">
    <div class="card-body" style="padding:16px;display:flex;gap:16px;flex-wrap:wrap;">
      <a href="{{ route('cadres.template') }}" class="btn btn-primary" style="background:#1d6f42;border-color:#1d6f42;font-size:12px;align-self:flex-start;">
        <i class="fas fa-download"></i> Modèle Cadres
      </a>
      <form method="POST" action="{{ route('cadres.import') }}" enctype="multipart/form-data" style="display:flex;gap:10px;align-items:flex-end;flex:1;">
        @csrf
        <div class="form-group" style="margin:0;flex:1;">
          <label class="form-label" style="font-size:12px;">Fichier Excel (.xlsx, .xls, .csv)</label>
          <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv" required style="font-size:12px;">
        </div>
        <button type="submit" class="btn btn-primary" style="font-size:12px;padding:6px 14px;" onclick="return confirm('Importer les cadres ?')">
          <i class="fas fa-upload"></i> Importer
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Import Excel Échelons -->
<div class="card" style="margin-bottom:20px;">
  <div class="card-header" style="cursor:pointer;" onclick="this.nextElementSibling.style.display = this.nextElementSibling.style.display==='none'?'block':'none'">
    <span class="card-title"><i class="fas fa-file-excel" style="color:#1d6f42;margin-right:6px;"></i>Importer des <strong>Échelons</strong> via Excel</span>
    <span style="font-size:12px;color:var(--secondary);">▼ Cliquer</span>
  </div>
  <div style="display:none;">
    <div class="card-body" style="padding:16px;display:flex;gap:16px;flex-wrap:wrap;">
      <a href="{{ route('echelons.template') }}" class="btn btn-primary" style="background:#1d6f42;border-color:#1d6f42;font-size:12px;align-self:flex-start;">
        <i class="fas fa-download"></i> Modèle Échelons
      </a>
      <form method="POST" action="{{ route('echelons.import') }}" enctype="multipart/form-data" style="display:flex;gap:10px;align-items:flex-end;flex:1;">
        @csrf
        <div class="form-group" style="margin:0;flex:1;">
          <label class="form-label" style="font-size:12px;">Fichier Excel (.xlsx, .xls, .csv)</label>
          <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv" required style="font-size:12px;">
        </div>
        <button type="submit" class="btn btn-primary" style="font-size:12px;padding:6px 14px;" onclick="return confirm('Importer les échelons ?')">
          <i class="fas fa-upload"></i> Importer
        </button>
      </form>
    </div>
  </div>
</div>

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

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">

  {{-- ══ GRADES ══ --}}
  <div class="card">
    <div class="card-header">
      <span class="card-title"><i class="fas fa-award" style="margin-right:6px;color:var(--primary);"></i>Grades</span>
      <button class="btn-sm" onclick="toggleForm('form-grade')"><i class="fas fa-plus"></i> Ajouter</button>
    </div>

    {{-- Form ajout grade --}}
    <div id="form-grade" style="display:none;padding:14px 20px;border-bottom:1px solid #e3e6f0;background:#f8f9fc;">
      <form method="POST" action="{{ route('grades.store') }}" style="display:flex;flex-direction:column;gap:8px;">
        @csrf
        <input type="text" name="GRADE" class="form-control" placeholder="Code grade *" required maxlength="50">
        <input type="text" name="Lib_grade_FR" class="form-control" placeholder="Libellé FR *" required maxlength="200">
        <input type="text" name="Lib_grade_AR" class="form-control" placeholder="Libellé AR" maxlength="200" dir="rtl">
        <button type="submit" class="btn btn-primary" style="align-self:flex-start;padding:6px 14px;font-size:12px;">
          <i class="fas fa-save"></i> Enregistrer
        </button>
      </form>
    </div>

    <div class="card-body" style="padding:0;">
      <table>
        <thead><tr><th>Code</th><th>Libellé FR</th><th></th></tr></thead>
        <tbody>
          @forelse($grades as $gr)
          <tr>
            <td><span class="badge-pill badge-primary">{{ $gr->GRADE }}</span></td>
            <td style="font-weight:600;">{{ $gr->Lib_grade_FR }}</td>
            <td style="white-space:nowrap;">
              <button class="btn-sm" onclick="toggleEditGrade({{ $gr->id_grade }})" title="Modifier">
                <i class="fas fa-edit"></i>
              </button>
              <form action="{{ route('grades.destroy', $gr) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm" style="color:var(--danger);"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
          {{-- Inline edit --}}
          <tr id="edit-grade-{{ $gr->id_grade }}" style="display:none;background:#f8f9fc;">
            <td colspan="3" style="padding:10px;">
              <form method="POST" action="{{ route('grades.update', $gr) }}" style="display:flex;gap:6px;flex-wrap:wrap;">
                @csrf @method('PUT')
                <input type="text" name="GRADE" class="form-control" value="{{ $gr->GRADE }}" style="width:100px;" required>
                <input type="text" name="Lib_grade_FR" class="form-control" value="{{ $gr->Lib_grade_FR }}" style="flex:1;" required>
                <input type="text" name="Lib_grade_AR" class="form-control" value="{{ $gr->Lib_grade_AR }}" style="width:130px;" dir="rtl">
                <button type="submit" class="btn btn-primary" style="padding:6px 12px;font-size:12px;"><i class="fas fa-save"></i></button>
                <button type="button" class="btn-sm" onclick="toggleEditGrade({{ $gr->id_grade }})">Annuler</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="3" style="text-align:center;padding:20px;color:var(--secondary);">Aucun grade</td></tr>
          @endforelse
        </tbody>
      </table>
      @if($grades->hasPages())
        <div style="padding:10px 14px;">{{ $grades->links() }}</div>
      @endif
    </div>
  </div>

  {{-- ══ CADRES ══ --}}
  <div class="card">
    <div class="card-header">
      <span class="card-title"><i class="fas fa-user-tag" style="margin-right:6px;color:var(--success);"></i>Cadres</span>
      <button class="btn-sm" onclick="toggleForm('form-cadre')"><i class="fas fa-plus"></i> Ajouter</button>
    </div>

    <div id="form-cadre" style="display:none;padding:14px 20px;border-bottom:1px solid #e3e6f0;background:#f8f9fc;">
      <form method="POST" action="{{ route('cadres.store') }}" style="display:flex;flex-direction:column;gap:8px;">
        @csrf
        <input type="text" name="CADRE" class="form-control" placeholder="Code cadre *" required maxlength="50">
        <input type="text" name="Lib_Cadre_FR" class="form-control" placeholder="Libellé FR *" required maxlength="200">
        <input type="text" name="Lib_cadre_AR" class="form-control" placeholder="Libellé AR" maxlength="200" dir="rtl">
        <button type="submit" class="btn btn-primary" style="align-self:flex-start;padding:6px 14px;font-size:12px;">
          <i class="fas fa-save"></i> Enregistrer
        </button>
      </form>
    </div>

    <div class="card-body" style="padding:0;">
      <table>
        <thead><tr><th>Code</th><th>Libellé FR</th><th></th></tr></thead>
        <tbody>
          @forelse($cadres as $cd)
          <tr>
            <td><span class="badge-pill badge-success">{{ $cd->CADRE }}</span></td>
            <td style="font-weight:600;">{{ $cd->Lib_Cadre_FR }}</td>
            <td>
              <form action="{{ route('cadres.destroy', $cd) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm" style="color:var(--danger);"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="3" style="text-align:center;padding:20px;color:var(--secondary);">Aucun cadre</td></tr>
          @endforelse
        </tbody>
      </table>
      @if($cadres->hasPages())
        <div style="padding:10px 14px;">{{ $cadres->links() }}</div>
      @endif
    </div>
  </div>

  {{-- ══ ÉCHELONS ══ --}}
  <div class="card">
    <div class="card-header">
      <span class="card-title"><i class="fas fa-layer-group" style="margin-right:6px;color:var(--info);"></i>Échelons</span>
      <button class="btn-sm" onclick="toggleForm('form-echelon')"><i class="fas fa-plus"></i> Ajouter</button>
    </div>

    <div id="form-echelon" style="display:none;padding:14px 20px;border-bottom:1px solid #e3e6f0;background:#f8f9fc;">
      <form method="POST" action="{{ route('echelons.store') }}" style="display:flex;flex-direction:column;gap:8px;">
        @csrf
        <input type="text" name="COD_ECH" class="form-control" placeholder="Code échelon *" required maxlength="20">
        <input type="text" name="COD_ELO" class="form-control" placeholder="Code ELO" maxlength="20">
        <button type="submit" class="btn btn-primary" style="align-self:flex-start;padding:6px 14px;font-size:12px;">
          <i class="fas fa-save"></i> Enregistrer
        </button>
      </form>
    </div>

    <div class="card-body" style="padding:0;">
      <table>
        <thead><tr><th>Code Éch.</th><th>Code ELO</th><th></th></tr></thead>
        <tbody>
          @forelse($echelons as $ech)
          <tr>
            <td><span class="badge-pill badge-info">{{ $ech->COD_ECH }}</span></td>
            <td>{{ $ech->COD_ELO ?? '-' }}</td>
            <td>
              <form action="{{ route('echelons.destroy', $ech) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm" style="color:var(--danger);"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="3" style="text-align:center;padding:20px;color:var(--secondary);">Aucun échelon</td></tr>
          @endforelse
        </tbody>
      </table>
      @if($echelons->hasPages())
        <div style="padding:10px 14px;">{{ $echelons->links() }}</div>
      @endif
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
function toggleForm(id) {
  const el = document.getElementById(id);
  el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
function toggleEditGrade(id) {
  const el = document.getElementById('edit-grade-' + id);
  el.style.display = el.style.display === 'none' ? 'table-row' : 'none';
}
</script>
@endpush
