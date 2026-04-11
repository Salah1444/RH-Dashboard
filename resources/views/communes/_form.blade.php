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
                <i class="fas fa-city mr-2"></i>Informations de la commune
            </h6>
        </div>
        <div class="card-body">
            {{-- Noms --}}
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold small">Nom (FR) <span class="text-danger">*</span></label>
                    <input type="text" name="LIB_COMMUNE_FR"
                           class="form-control @error('LIB_COMMUNE_FR') is-invalid @enderror"
                           value="{{ old('LIB_COMMUNE_FR', $commune->LIB_COMMUNE_FR ?? '') }}"
                           placeholder="Ex: Agadir">
                    @error('LIB_COMMUNE_FR')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="font-weight-bold small">الاسم (AR)</label>
                    <input type="text" name="LIB_COMMUNE_AR"
                           class="form-control text-right" dir="rtl"
                           value="{{ old('LIB_COMMUNE_AR', $commune->LIB_COMMUNE_AR ?? '') }}"
                           placeholder="أكادير">
                </div>
            </div>
            {{-- Milieu --}}
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="font-weight-bold small">Milieu (FR)</label>
                    <select name="LIB_MILIEU_FR" class="form-control">
                        <option value="">— Sélectionner —</option>
                        @foreach(['Urbain', 'Rural'] as $m)
                            <option value="{{ $m }}"
                                {{ old('LIB_MILIEU_FR', $commune->LIB_MILIEU_FR ?? '') === $m ? 'selected' : '' }}>
                                {{ $m }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label class="font-weight-bold small">الوسط (AR)</label>
                    <select name="LIB_MILIEU_AR" class="form-control text-right" dir="rtl">
                        <option value="">— اختر —</option>
                        @foreach(['حضري' => 'Urbain', 'قروي' => 'Rural'] as $ar => $fr)
                            <option value="{{ $ar }}"
                                {{ old('LIB_MILIEU_AR', $commune->LIB_MILIEU_AR ?? '') === $ar ? 'selected' : '' }}>
                                {{ $ar }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- Province --}}
            <div class="form-group mb-0">
                <label class="font-weight-bold small">Province</label>
                <select name="CD_PRV"
                        class="form-control @error('CD_PRV') is-invalid @enderror">
                    <option value="">— Sélectionner une province —</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->CD_PRV }}"
                            {{ old('CD_PRV', $commune->CD_PRV ?? '') == $province->CD_PRV ? 'selected' : '' }}>
                            {{ $province->LIB_PROVINCE_FR }}
                            @if($province->region) — {{ $province->region->LIB_REGION_FR }} @endif
                        </option>
                    @endforeach
                </select>
                @error('CD_PRV')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body d-flex justify-content-between">
            <a href="{{ route('communes.index') }}" class="btn btn-light">
                <i class="fas fa-times mr-1"></i>Annuler
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i>Enregistrer
            </button>
        </div>
    </div>
</form>
