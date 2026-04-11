@extends('layouts.master')
@section('title','Situations Statutaires')
@section('page-title','Situations Statutaires')

@section('content')

<div class="page-header">
  <h1><i class="fas fa-balance-scale mr-2 text-primary"></i>Situations Statutaires</h1>
</div>
<hr style="margin:20px 0;">



{{-- KPI --}}
<div class="kpi-grid" style="grid-template-columns:repeat(2,1fr);max-width:500px;margin-bottom:25px;">
  <div class="kpi-card primary">
    <div><div class="kpi-label">Situations</div><div class="kpi-value">{{ $totalSituations }}</div></div>
    <div class="kpi-icon"><i class="fas fa-balance-scale"></i></div>
  </div>
  <div class="kpi-card info">
    <div><div class="kpi-label">Historiques</div><div class="kpi-value">{{ $sitHistories->total() }}</div></div>
    <div class="kpi-icon"><i class="fas fa-history"></i></div>
  </div>
</div>

<h3>Imports Excel — Situation
</h3>
<x-excel-import
  :import-route="route('situations.import')"
  :template-route="route('situations.template')"
  label="situations"
/>
<div style="display:grid;grid-template-columns:1fr 2fr;gap:24px;">

  {{-- RÉFÉRENTIEL --}}
  <div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span class="font-weight-bold"><i class="fas fa-balance-scale mr-1"></i> Référentiel</span>
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAddSituation">
        <i class="fas fa-plus"></i>
      </button>
    </div>
    <div class="card-body p-0">
      <table class="table table-sm table-hover mb-0">
        <thead class="thead-light">
          <tr><th>Code</th><th>Libellé</th><th class="text-center">Nb</th><th></th></tr>
        </thead>
        <tbody>
        @forelse($situations as $s)
          <tr>
            <td><span class="badge badge-primary">{{ $s->CODE_SIT_STATUTAIRE }}</span></td>
            <td>
              <div>{{ $s->LIB_SITUATION_STATUTAIRE_FR }}</div>
              @if($s->LIB_SITUATION_STATUTAIRE_AR)
                <small class="text-muted" dir="rtl">{{ $s->LIB_SITUATION_STATUTAIRE_AR }}</small>
              @endif
            </td>
            <td class="text-center"><span class="badge badge-secondary">{{ $s->histories_count }}</span></td>
            <td class="text-right">
              <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                data-target="#editSit{{ $s->sit_st_id }}"><i class="fas fa-edit"></i></button>
              <form action="{{ route('situations.destroy', $s->sit_st_id) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Supprimer cette situation ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted py-3">Aucune situation.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    @if($situations->hasPages()) <div class="card-footer">{{ $situations->links() }}</div> @endif
  </div>

  @foreach($situations as $s)
  <div class="modal fade" id="editSit{{ $s->sit_st_id }}" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Modifier situation</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button></div>
      <form action="{{ route('situations.update', $s->sit_st_id) }}" method="POST">
        @csrf @method('PUT')
        <div class="modal-body">
          <div class="form-group"><label>Code <span class="text-danger">*</span></label>
            <input type="text" name="CODE_SIT_STATUTAIRE" class="form-control"
              value="{{ $s->CODE_SIT_STATUTAIRE }}" required maxlength="30"></div>
          <div class="form-group"><label>Libellé (FR) <span class="text-danger">*</span></label>
            <input type="text" name="LIB_SITUATION_STATUTAIRE_FR" class="form-control"
              value="{{ $s->LIB_SITUATION_STATUTAIRE_FR }}" required></div>
          <div class="form-group"><label>الاسم (AR)</label>
            <input type="text" name="LIB_SITUATION_STATUTAIRE_AR" class="form-control text-right" dir="rtl"
              value="{{ $s->LIB_SITUATION_STATUTAIRE_AR }}"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-warning">Enregistrer</button>
        </div>
      </form>
    </div></div>
  </div>
  @endforeach


  {{-- HISTORIQUES --}}
  <div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span class="font-weight-bold"><i class="fas fa-history mr-1"></i> Historiques</span>
      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAddSitHistory">
        <i class="fas fa-plus mr-1"></i> Ajouter
      </button>
    </div>
    <div class="card-body p-0">
      <div class="p-3 border-bottom bg-light">
        <x-excel-import
          :import-route="route('situations.history.import')"
          :template-route="route('situations.history.template')"
          label="situation-histories"
        />
      </div>
      <table class="table table-sm table-hover mb-0">
        <thead class="thead-light">
          <tr><th>Employé</th><th>Situation</th><th>Date stat.</th><th>Prév. retraite</th><th></th></tr>
        </thead>
        <tbody>
        @forelse($sitHistories as $h)
          <tr>
            <td class="small">{{ $h->employer->NOM_PRENOM_FR ?? '-' }}</td>
            <td><span class="badge badge-primary">{{ $h->situationStatutaire->CODE_SIT_STATUTAIRE ?? '-' }}</span>
              <small class="d-block text-muted">{{ $h->situationStatutaire->LIB_SITUATION_STATUTAIRE_FR ?? '' }}</small>
            </td>
            <td class="small">{{ $h->DATE_SIT_STAT?->format('d/m/Y') ?? '-' }}</td>
            <td class="small">
              @if($h->DATE_PREV_RETRAITE)
                @php $diff = now()->diffInMonths($h->DATE_PREV_RETRAITE, false) @endphp
                <span class="{{ $diff < 12 ? 'text-danger font-weight-bold' : '' }}">
                  {{ $h->DATE_PREV_RETRAITE->format('d/m/Y') }}
                </span>
                @if($diff < 12 && $diff >= 0)
                  <span class="badge badge-danger ml-1">{{ $diff }}m</span>
                @endif
              @else
                <span class="text-muted">—</span>
              @endif
            </td>
            <td class="text-right">
              <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                data-target="#editSitHist{{ $h->id }}"><i class="fas fa-edit"></i></button>
              <form action="{{ route('situations.history.destroy', $h->id) }}" method="POST" class="d-inline"
                onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
          {{-- Edit Situation History Modal --}}
          <div class="modal fade" id="editSitHist{{ $h->id }}" tabindex="-1">
            <div class="modal-dialog"><div class="modal-content">
              <div class="modal-header"><h5 class="modal-title">Modifier historique situation</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button></div>
              <form action="{{ route('situations.history.update', $h->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                  <div class="form-group"><label>Employé <span class="text-danger">*</span></label>
                    <select name="code_agent" class="form-control" required>
                      @foreach($employers as $emp)
                        <option value="{{ $emp->COD_AG }}" {{ $h->code_agent == $emp->COD_AG ? 'selected' : '' }}>{{ $emp->NOM_PRENOM_FR }}</option>
                      @endforeach
                    </select></div>
                  <div class="form-group"><label>Situation <span class="text-danger">*</span></label>
                    <select name="sit_st_id" class="form-control" required>
                      @foreach($situations as $s)
                        <option value="{{ $s->sit_st_id }}" {{ $h->sit_st_id == $s->sit_st_id ? 'selected' : '' }}>{{ $s->LIB_SITUATION_STATUTAIRE_FR }}</option>
                      @endforeach
                    </select></div>
                  <div class="form-row">
                    <div class="form-group col-md-6"><label>Date situation</label>
                      <input type="date" name="DATE_SIT_STAT" class="form-control"
                        value="{{ $h->DATE_SIT_STAT?->format('Y-m-d') }}"></div>
                    <div class="form-group col-md-6"><label>Date prév. retraite</label>
                      <input type="date" name="DATE_PREV_RETRAITE" class="form-control"
                        value="{{ $h->DATE_PREV_RETRAITE?->format('Y-m-d') }}"></div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                  <button type="submit" class="btn btn-warning">Enregistrer</button>
                </div>
              </form>
            </div></div>
          </div>
        @empty
          <tr><td colspan="5" class="text-center text-muted py-3">Aucun historique.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    @if($sitHistories->hasPages()) <div class="card-footer">{{ $sitHistories->links() }}</div> @endif
  </div>

</div>

{{-- ===== ADD MODALS ===== --}}

{{-- Add Situation --}}
<div class="modal fade" id="modalAddSituation" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title"><i class="fas fa-balance-scale mr-1"></i> Nouvelle situation statutaire</h5>
      <button type="button" class="close" data-dismiss="modal">&times;</button></div>
    <form action="{{ route('situations.store') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-group"><label>Code <span class="text-danger">*</span></label>
          <input type="text" name="CODE_SIT_STATUTAIRE" class="form-control @error('CODE_SIT_STATUTAIRE') is-invalid @enderror"
            placeholder="Ex: ACT" maxlength="30" required>
          @error('CODE_SIT_STATUTAIRE')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group"><label>Libellé (FR) <span class="text-danger">*</span></label>
          <input type="text" name="LIB_SITUATION_STATUTAIRE_FR" class="form-control @error('LIB_SITUATION_STATUTAIRE_FR') is-invalid @enderror"
            placeholder="En activité" required>
          @error('LIB_SITUATION_STATUTAIRE_FR')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group"><label>الاسم (AR)</label>
          <input type="text" name="LIB_SITUATION_STATUTAIRE_AR" class="form-control text-right" dir="rtl"
            placeholder="في الخدمة"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary">Créer</button>
      </div>
    </form>
  </div></div>
</div>

{{-- Add Situation History --}}
<div class="modal fade" id="modalAddSitHistory" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title"><i class="fas fa-history mr-1"></i> Ajouter historique situation</h5>
      <button type="button" class="close" data-dismiss="modal">&times;</button></div>
    <form action="{{ route('situations.history.store') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-group"><label>Employé <span class="text-danger">*</span></label>
          <select name="code_agent" class="form-control" required>
            <option value="">— Sélectionner —</option>
            @foreach($employers as $emp)
              <option value="{{ $emp->COD_AG }}">{{ $emp->NOM_PRENOM_FR }}</option>
            @endforeach
          </select></div>
        <div class="form-group"><label>Situation <span class="text-danger">*</span></label>
          <select name="sit_st_id" class="form-control" required>
            <option value="">— Sélectionner —</option>
            @foreach($situations as $s)
              <option value="{{ $s->sit_st_id }}">{{ $s->LIB_SITUATION_STATUTAIRE_FR }}</option>
            @endforeach
          </select></div>
        <div class="form-row">
          <div class="form-group col-md-6"><label>Date situation</label>
            <input type="date" name="DATE_SIT_STAT" class="form-control"></div>
          <div class="form-group col-md-6"><label>Date prévue retraite</label>
            <input type="date" name="DATE_PREV_RETRAITE" class="form-control"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-success">Enregistrer</button>
      </div>
    </form>
  </div></div>
</div>

@endsection
