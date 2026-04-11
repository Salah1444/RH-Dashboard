@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-network-wired mr-2"></i>Informations du réseau
            </h6>
        </div>
        <div class="card-body">
            <div class="form-group mb-0">
                <label class="font-weight-bold small">
                    Libellé du réseau <span class="text-danger">*</span>
                </label>
                <input type="text" name="LIBELLE_net_etab"
                       class="form-control @error('LIBELLE_net_etab') is-invalid @enderror"
                       value="{{ old('LIBELLE_net_etab', $netEtab->LIBELLE_net_etab ?? '') }}"
                       placeholder="Ex: Réseau Centre">
                @error('LIBELLE_net_etab')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body d-flex justify-content-between">
            <a href="{{ route('net_etabs.index') }}" class="btn btn-light">
                <i class="fas fa-times mr-1"></i>Annuler
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i>Enregistrer
            </button>
        </div>
    </div>
</form>
