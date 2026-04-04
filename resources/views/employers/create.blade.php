@extends('layouts.master')

@php
    $isRtl = app()->getLocale() === 'ar';
@endphp

@section('main')
    <div class="container-fluid employer-create-page"
         dir="{{ $isRtl ? 'rtl' : 'ltr' }}"
         lang="{{ app()->getLocale() }}"
         style="font-family: 'Cairo', 'Nunito', sans-serif;">

        <div class="d-sm-flex align-items-center justify-content-between mb-4 flex-wrap">
            <div class="d-flex align-items-center flex-wrap mb-2 mb-sm-0">
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                    <i class="fas fa-user-plus text-primary {{ $isRtl ? 'ml-2' : 'mr-2' }}"></i>{{ __('employer_create.title') }}
                </h1>
                <div class="btn-group btn-group-sm {{ $isRtl ? 'mr-3' : 'ml-3' }}" role="group" aria-label="{{ __('employer_create.language') }}">
                    <a href="{{ route('locale.switch', ['locale' => 'fr']) }}"
                       class="btn {{ app()->isLocale('fr') ? 'btn-primary' : 'btn-outline-secondary' }} shadow-sm">
                        {{ __('employer_create.lang_fr') }}
                    </a>
                    <a href="{{ route('locale.switch', ['locale' => 'ar']) }}"
                       class="btn {{ app()->isLocale('ar') ? 'btn-primary' : 'btn-outline-secondary' }} shadow-sm"
                       style="font-family: 'Cairo', sans-serif;">
                        {{ __('employer_create.lang_ar') }}
                    </a>
                </div>
            </div>
            <a href="{{ route('employers.index') }}" class="btn btn-sm btn-outline-secondary shadow-sm">
                <i class="fas fa-arrow-{{ $isRtl ? 'right' : 'left' }} fa-sm {{ $isRtl ? 'ml-1' : 'mr-1' }}"></i>
                {{ __('employer_create.back_to_list') }}
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success shadow-sm border-0 mb-4" role="alert" style="border-radius:12px;">
                <i class="fas fa-check-circle {{ $isRtl ? 'ml-2' : 'mr-2' }}"></i>{{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger shadow-sm border-0 mb-4" role="alert" style="border-radius:12px;">
                <div class="font-weight-bold mb-1">{{ __('employer_create.errors_title') }}</div>
                <ul class="mb-0 {{ $isRtl ? 'pr-3' : 'pl-3' }}">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="card shadow border-0 mb-4" style="border-radius:14px;">
                    <div class="card-header py-3"
                         style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius:14px 14px 0 0;">
                        <h6 class="m-0 font-weight-bold text-white">
                            <i class="fas fa-id-card {{ $isRtl ? 'ml-2' : 'mr-2' }}"></i>{{ __('employer_create.manual_entry') }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('employers.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold text-secondary small" for="CIN_A">{{ __('employer_create.cin_alpha') }}</label>
                                    <input type="text" name="CIN_A" id="CIN_A" value="{{ old('CIN_A') }}"
                                           class="form-control @error('CIN_A') is-invalid @enderror" maxlength="20">
                                    @error('CIN_A')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold text-secondary small" for="CIN_N">{{ __('employer_create.cin_numeric') }}</label>
                                    <input type="text" name="CIN_N" id="CIN_N" value="{{ old('CIN_N') }}"
                                           class="form-control @error('CIN_N') is-invalid @enderror" maxlength="20">
                                    @error('CIN_N')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold text-secondary small" for="CIN">{{ __('employer_create.cin_full') }}</label>
                                    <input type="text" name="CIN" id="CIN" value="{{ old('CIN') }}"
                                           class="form-control @error('CIN') is-invalid @enderror" maxlength="20">
                                    @error('CIN')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-secondary small" for="NOM_PRENOM_FR">{{ __('employer_create.nom_prenom_fr') }}</label>
                                    <input type="text" name="NOM_PRENOM_FR" id="NOM_PRENOM_FR" value="{{ old('NOM_PRENOM_FR') }}"
                                           class="form-control @error('NOM_PRENOM_FR') is-invalid @enderror" maxlength="200">
                                    @error('NOM_PRENOM_FR')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-secondary small" for="NOM_PRENOM_AR">{{ __('employer_create.nom_prenom_ar') }}</label>
                                    <input type="text" name="NOM_PRENOM_AR" id="NOM_PRENOM_AR" value="{{ old('NOM_PRENOM_AR') }}"
                                           class="form-control @error('NOM_PRENOM_AR') is-invalid @enderror" maxlength="200"
                                           dir="rtl" style="font-family: 'Cairo', sans-serif;">
                                    @error('NOM_PRENOM_AR')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold text-secondary small" for="DATE_NAISS">{{ __('employer_create.date_naissance') }}</label>
                                    <input type="date" name="DATE_NAISS" id="DATE_NAISS" value="{{ old('DATE_NAISS') }}"
                                           class="form-control @error('DATE_NAISS') is-invalid @enderror">
                                    @error('DATE_NAISS')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold text-secondary small" for="LIEU_NAISS">{{ __('employer_create.lieu_naissance') }}</label>
                                    <input type="text" name="LIEU_NAISS" id="LIEU_NAISS" value="{{ old('LIEU_NAISS') }}"
                                           class="form-control @error('LIEU_NAISS') is-invalid @enderror" maxlength="150">
                                    @error('LIEU_NAISS')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold text-secondary small" for="SEXE">{{ __('employer_create.genre') }}</label>
                                    <select name="SEXE" id="SEXE" class="form-control @error('SEXE') is-invalid @enderror">
                                        <option value="">{{ __('employer_create.gender_placeholder') }}</option>
                                        <option value="M" @selected(old('SEXE') === 'M')>{{ __('employer_create.gender_m') }}</option>
                                        <option value="F" @selected(old('SEXE') === 'F')>{{ __('employer_create.gender_f') }}</option>
                                    </select>
                                    @error('SEXE')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-secondary small" for="ville_id">{{ __('employer_create.ville_id') }}</label>
                                    <select name="ville_id" id="ville_id" class="form-control @error('ville_id') is-invalid @enderror">
                                        <option value="">{{ __('employer_create.select_placeholder') }}</option>
                                        @foreach ($communes as $c)
                                            <option value="{{ $c->CD_COM }}" @selected(old('ville_id') == $c->CD_COM)>
                                                {{ $c->LIB_COMMUNE_FR }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ville_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-secondary small" for="position_id">{{ __('employer_create.position_id') }}</label>
                                    <select name="position_id" id="position_id" class="form-control @error('position_id') is-invalid @enderror">
                                        <option value="">{{ __('employer_create.select_placeholder') }}</option>
                                        @foreach ($positions as $p)
                                            <option value="{{ $p->COD_POS }}" @selected(old('position_id') == $p->COD_POS)>
                                                {{ $p->LIB_POSITION_FR }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('position_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-secondary small" for="ADRESSE_FR">{{ __('employer_create.adresse_fr') }}</label>
                                    <input type="text" name="ADRESSE_FR" id="ADRESSE_FR" value="{{ old('ADRESSE_FR') }}"
                                           class="form-control @error('ADRESSE_FR') is-invalid @enderror" maxlength="255">
                                    @error('ADRESSE_FR')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-secondary small" for="ADRESSE_AR">{{ __('employer_create.adresse_ar') }}</label>
                                    <input type="text" name="ADRESSE_AR" id="ADRESSE_AR" value="{{ old('ADRESSE_AR') }}"
                                           class="form-control @error('ADRESSE_AR') is-invalid @enderror" maxlength="255" dir="rtl">
                                    @error('ADRESSE_AR')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold text-secondary small" for="TEL_FIXE">{{ __('employer_create.tel_fixe') }}</label>
                                    <input type="text" name="TEL_FIXE" id="TEL_FIXE" value="{{ old('TEL_FIXE') }}"
                                           class="form-control @error('TEL_FIXE') is-invalid @enderror" maxlength="20">
                                    @error('TEL_FIXE')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold text-secondary small" for="TEL_PORTABLE">{{ __('employer_create.tel_portable') }}</label>
                                    <input type="text" name="TEL_PORTABLE" id="TEL_PORTABLE" value="{{ old('TEL_PORTABLE') }}"
                                           class="form-control @error('TEL_PORTABLE') is-invalid @enderror" maxlength="20">
                                    @error('TEL_PORTABLE')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold text-secondary small" for="ADRESSE_ELEC">{{ __('employer_create.adresse_email') }}</label>
                                    <input type="text" name="ADRESSE_ELEC" id="ADRESSE_ELEC" value="{{ old('ADRESSE_ELEC') }}"
                                           class="form-control @error('ADRESSE_ELEC') is-invalid @enderror" maxlength="150">
                                    @error('ADRESSE_ELEC')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold text-secondary small" for="Sit_Familiale">{{ __('employer_create.sit_familiale') }}</label>
                                    <input type="text" name="Sit_Familiale" id="Sit_Familiale" value="{{ old('Sit_Familiale') }}"
                                           class="form-control @error('Sit_Familiale') is-invalid @enderror" maxlength="100">
                                    @error('Sit_Familiale')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold text-secondary small" for="CODE_NAT">{{ __('employer_create.code_national') }}</label>
                                    <input type="text" name="CODE_NAT" id="CODE_NAT" value="{{ old('CODE_NAT') }}"
                                           class="form-control @error('CODE_NAT') is-invalid @enderror" maxlength="20">
                                    @error('CODE_NAT')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="font-weight-bold text-secondary small" for="RIB">{{ __('employer_create.rib') }}</label>
                                    <input type="text" name="RIB" id="RIB" value="{{ old('RIB') }}"
                                           class="form-control @error('RIB') is-invalid @enderror" maxlength="30">
                                    @error('RIB')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="font-weight-bold text-secondary small" for="NUM_PB">{{ __('employer_create.num_pb') }}</label>
                                    <input type="text" name="NUM_PB" id="NUM_PB" value="{{ old('NUM_PB') }}"
                                           class="form-control @error('NUM_PB') is-invalid @enderror" maxlength="30">
                                    @error('NUM_PB')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="label-control font-weight-bold text-secondary small" for="photo">{{ __('employer_create.photo') }}</label>
                                    <input type="file" name="photo" id="photo" accept="image/*"
                                           class="form-control @error('photo') is-invalid @enderror">
                                    @error('photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary shadow-sm px-4" style="border-radius:10px;">
                                <i class="fas fa-save {{ $isRtl ? 'ml-2' : 'mr-2' }}"></i>{{ __('employer_create.save') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 mb-4">
                <div class="card shadow border-0 mb-4" style="border-radius:14px;">
                    <div class="card-header py-3"
                         style="background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); border-radius:14px 14px 0 0;">
                        <h6 class="m-0 font-weight-bold text-white">
                            <i class="fas fa-file-excel {{ $isRtl ? 'ml-2' : 'mr-2' }}"></i>{{ __('employer_create.excel_import') }}
                        </h6>
                    </div>
                    <div class="card-body">
                        
                        <a href="{{ route('employers.import.template') }}"
                           class="btn btn-outline-success btn-block mb-4 shadow-sm" style="border-radius:10px;">
                            <i class="fas fa-download {{ $isRtl ? 'ml-2' : 'mr-2' }}"></i>{{ __('employer_create.download_template') }}
                        </a>

                        <form action="{{ route('employers.import') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="form-label font-weight-bold text-secondary small" for="import_file">{{ __('employer_create.file_label') }}</label>
                                <input type="file" name="file" id="import_file" required
                                       class="form-control @error('file') is-invalid @enderror"
                                       accept=".xlsx,.xls,.csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,text/csv">
                                @error('file')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <button type="submit" class="btn btn-success shadow-sm btn-block" style="border-radius:10px;">
                                <i class="fas fa-upload {{ $isRtl ? 'ml-2' : 'mr-2' }}"></i>{{ __('employer_create.run_import') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
