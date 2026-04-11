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
                <i class="fas fa-building mr-2"></i>Informations de la modiriya
            </h6>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label class="font-weight-bold small">
                    Nom de la modiriya <span class="text-danger">*</span>
                </label>
                <input type="text" name="nom_modiriya"
                       class="form-control @error('nom_modiriya') is-invalid @enderror"
                       value="{{ old('nom_modiriya', $modiriya->nom_modiriya ?? '') }}"
                       placeholder="Ex: مديرية أكادير">
                @error('nom_modiriya')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group mb-0">
                <label class="font-weight-bold small">Région</label>
                <select name="id_region"
                        class="form-control @error('id_region') is-invalid @enderror">
                    <option value="">— Sélectionner une région —</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->CD_REG }}"
                            {{ old('id_region', $modiriya->id_region ?? '') == $region->CD_REG ? 'selected' : '' }}>
                            {{ $region->LIB_REGION_FR }}
                        </option>
                    @endforeach
                </select>
                @error('id_region')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body d-flex justify-content-between">
            <a href="{{ route('modiriyas.index') }}" class="btn btn-light">
                <i class="fas fa-times mr-1"></i>Annuler
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i>Enregistrer
            </button>
        </div>
    </div>
</form>
