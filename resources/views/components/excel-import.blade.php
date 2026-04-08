
@props(['importRoute', 'templateRoute', 'label' => 'données'])


@if(session('error'))
  <div style="background:#f8d7da;border:1px solid #f5c6cb;color:#721c24;padding:12px 16px;border-radius:6px;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
  </div>
@endif

<div class="card" style="margin-bottom:20px;">
  <div class="card-header" style="cursor:pointer;user-select:none;" onclick="toggleExcelPanel(this)">
    <span class="card-title">
      <i class="fas fa-file-excel" style="color:#1d6f42;margin-right:6px;"></i>
      Importer via Excel
    </span>
    <span style="font-size:12px;color:var(--secondary);">
      <i class="fas fa-chevron-down" id="excel-chevron-{{ Str::random(4) }}"></i> Cliquer pour ouvrir
    </span>
  </div>
  <div class="excel-panel" style="display:none;">
    <div class="card-body" style="padding:16px;">
      <div style="display:flex;gap:16px;align-items:flex-start;flex-wrap:wrap;">

        {{-- Step 1: Download template --}}
        <div style="flex:1;min-width:220px;background:#f8f9fc;border:1px solid #e3e6f0;border-radius:8px;padding:14px;">
          <div style="font-weight:700;font-size:13px;margin-bottom:6px;color:var(--dark);">
            <span style="background:#1d6f42;color:#fff;border-radius:50%;width:20px;height:20px;display:inline-flex;align-items:center;justify-content:center;font-size:11px;margin-right:6px;">1</span>
            Télécharger le modèle
          </div>
          <p style="font-size:12px;color:var(--secondary);margin:0 0 10px 0;">
            Téléchargez le fichier Excel modèle, remplissez-le avec vos {{ $label }}, puis importez-le.
          </p>
          <a href="{{ $templateRoute }}" class="btn btn-primary" style="background:#1d6f42;border-color:#1d6f42;font-size:12px;padding:6px 14px;">
            <i class="fas fa-download"></i> Modèle Excel
          </a>
        </div>

        {{-- Step 2: Upload & import --}}
        <div style="flex:2;min-width:280px;background:#f8f9fc;border:1px solid #e3e6f0;border-radius:8px;padding:14px;">
          <div style="font-weight:700;font-size:13px;margin-bottom:6px;color:var(--dark);">
            <span style="background:#4e73df;color:#fff;border-radius:50%;width:20px;height:20px;display:inline-flex;align-items:center;justify-content:center;font-size:11px;margin-right:6px;">2</span>
            Importer votre fichier
          </div>
          <form method="POST" action="{{ $importRoute }}" enctype="multipart/form-data"
                style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap;">
            @csrf
            <div class="form-group" style="margin:0;flex:1;min-width:200px;">
              <label class="form-label" style="font-size:12px;">Fichier Excel (.xlsx, .xls, .csv)</label>
              <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls,.csv" required
                     >
              @error('excel_file')
                <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
              @enderror
            </div>
            <button type="submit" class="btn btn-primary" style="font-size:12px;padding:6px 14px;height:38px;"
                    onclick="return confirm('Confirmer l\'importation du fichier Excel ?')">
              <i class="fas fa-upload"></i> Importer
            </button>
          </form>
          <p style="font-size:11px;color:var(--secondary);margin:8px 0 0 0;">
            <i class="fas fa-info-circle"></i>
            Les lignes déjà existantes seront ignorées. Seules les nouvelles entrées seront ajoutées.
          </p>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
function toggleExcelPanel(header) {
  const panel = header.closest('.card').querySelector('.excel-panel');
  const isHidden = panel.style.display === 'none';
  panel.style.display = isHidden ? 'block' : 'none';
  const chevron = header.querySelector('.fa-chevron-down, .fa-chevron-up');
  if (chevron) {
    chevron.classList.toggle('fa-chevron-down', !isHidden);
    chevron.classList.toggle('fa-chevron-up', isHidden);
  }
}
// Auto-open if there's a flash message
document.addEventListener('DOMContentLoaded', function() {
  @if(session('success') || session('error') || $errors->has('excel_file'))
    document.querySelectorAll('.excel-panel').forEach(p => p.style.display = 'block');
  @endif
});
</script>
