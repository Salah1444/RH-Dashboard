{{-- resources/views/regions/_form.blade.php --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <strong><i class="fas fa-exclamation-triangle mr-1"></i>Erreurs :</strong>
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
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
                <i class="fas fa-globe-africa mr-2"></i>Informations de la région
            </h6>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold small">
                        Nom (Français) <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="LIB_REGION_FR"
                           class="form-control @error('LIB_REGION_FR') is-invalid @enderror"
                           value="{{ old('LIB_REGION_FR', $region->LIB_REGION_FR ?? '') }}"
                           placeholder="Ex: Souss-Massa">
                    @error('LIB_REGION_FR')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="font-weight-bold small">الاسم (العربية)</label>
                    <input type="text" name="LIB_REGION_AR"
                           class="form-control text-right"
                           dir="rtl"
                           value="{{ old('LIB_REGION_AR', $region->LIB_REGION_AR ?? '') }}"
                           placeholder="سوس ماسة">
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body d-flex justify-content-between">
            <a href="{{ route('regions.index') }}" class="btn btn-light">
                <i class="fas fa-times mr-1"></i>Annuler
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i>Enregistrer
            </button>
        </div>
    </div>
</form>
