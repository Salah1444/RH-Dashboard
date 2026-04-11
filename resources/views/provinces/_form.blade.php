@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-map mr-2"></i>Informations de la province
            </h6>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold small">
                        Nom (Français) <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="LIB_PROVINCE_FR"
                           class="form-control @error('LIB_PROVINCE_FR') is-invalid @enderror"
                           value="{{ old('LIB_PROVINCE_FR', $province->LIB_PROVINCE_FR ?? '') }}"
                           placeholder="Ex: Agadir-Ida-Ou-Tanane">
                    @error('LIB_PROVINCE_FR')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="font-weight-bold small">الاسم (العربية)</label>
                    <input type="text" name="LIB_PROVINCE_AR"
                           class="form-control text-right" dir="rtl"
                           value="{{ old('LIB_PROVINCE_AR', $province->LIB_PROVINCE_AR ?? '') }}"
                           placeholder="أكادير إداو تنان">
                </div>
            </div>
            <div class="form-group mb-0">
                <label class="font-weight-bold small">Région</label>
                <select name="CD_REG"
                        class="form-control @error('CD_REG') is-invalid @enderror">
                    <option value="">— Sélectionner une région —</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->CD_REG }}"
                            {{ old('CD_REG', $province->CD_REG ?? '') == $region->CD_REG ? 'selected' : '' }}>
                            {{ $region->LIB_REGION_FR }}
                        </option>
                    @endforeach
                </select>
                @error('CD_REG')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body d-flex justify-content-between">
            <a href="{{ route('provinces.index') }}" class="btn btn-light">
                <i class="fas fa-times mr-1"></i>Annuler
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i>Enregistrer
            </button>
        </div>
    </div>
</form>
