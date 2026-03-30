@extends('layouts.master')

@section('main')
@php
    $emp = $Employer;
    $fullName = trim((string) ($emp->NOM_PRENOM_FR ?? ''));
    $nameParts = preg_split('/\s+/', $fullName, 2) ?: [];
    $nom = $nameParts[0] ?? $fullName;
    $prenom = $nameParts[1] ?? '';
    $sexe = strtoupper((string) ($emp->SEXE ?? ''));
    $defaultPhoto = $sexe === 'F'
        ? asset('images/cv/default-female.png')
        : asset('images/cv/default-male.png');
    $photoPath = $emp->photo
        ? asset('storage/' . ltrim($emp->photo, '/'))
        : $defaultPhoto;
@endphp

<div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="h4 mb-1">Profil CV Employe</h2>
            <p class="text-muted mb-0">Fiche RH detaillee de l'employe</p>
        </div>
        <a href="{{ route('employers.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left mr-1"></i> Retour
        </a>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 text-center mb-3 mb-md-0">
                    <img src="{{ $photoPath }}" alt="Photo employe" class="img-fluid rounded border" style="max-height: 150px;">
                </div>

                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <small class="text-muted d-block">Nom</small>
                            <strong>{{ $nom ?: 'N/A' }}</strong>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted d-block">Prenom</small>
                            <strong>{{ $prenom ?: 'N/A' }}</strong>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted d-block">Nom complet</small>
                            <strong>{{ $emp->NOM_PRENOM_FR ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted d-block">Nom arabe</small>
                            <strong>{{ $emp->NOM_PRENOM_AR ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted d-block">Telephone</small>
                            <strong>{{ $emp->TEL_PORTABLE ?? $emp->TEL_FIXE ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted d-block">Email</small>
                            <strong>{{ $emp->ADRESSE_ELEC ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-md-8 mb-2">
                            <small class="text-muted d-block">Adresse</small>
                            <strong>{{ $emp->ADRESSE_FR ?? $emp->ADRESSE_AR ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-md-4 mb-2">
                            <small class="text-muted d-block">Position (FK)</small>
                            <strong>
                                {{ $emp->position_id ?? 'N/A' }}
                                @if($emp->position)
                                    - {{ $emp->position->LIB_POSITION_FR ?? 'N/A' }}
                                @endif
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white py-2">
                    Affectation actuelle
                </div>
                <div class="card-body">
                    @php $currentAff = $emp->affectationActuelle; @endphp
                    @if($currentAff)
                        <p class="mb-2"><strong>Affectation ID:</strong> {{ $currentAff->id_aff ?? 'N/A' }}</p>
                        <p class="mb-2">
                            <strong>Etablissement:</strong>
                            {{ $currentAff->etablissement_id ?? 'N/A' }}
                            @if($currentAff->etablissement)
                                - {{ $currentAff->etablissement->LIBELLE_FR_AFF ?? 'N/A' }}
                            @endif
                        </p>
                        <p class="mb-2">
                            <strong>Fonction:</strong>
                            {{ $currentAff->fonction_id ?? 'N/A' }}
                            @if($currentAff->fonction)
                                - {{ $currentAff->fonction->LIB_FONCTION_FR ?? 'N/A' }}
                            @endif
                        </p>
                        <p class="mb-0">
                            <strong>Date debut:</strong>
                            {{ optional($currentAff->DATE_DEBUT_AFF)->format('d/m/Y') ?? 'N/A' }}
                        </p>
                    @else
                        <p class="text-muted mb-0">Aucune affectation actuelle.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white py-2">
                    Statut actuel
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Cadre:</strong>
                        {{ $emp->cadreActuel?->id_cadre ?? 'N/A' }}
                        @if($emp->cadreActuel?->cadre)
                            - {{ $emp->cadreActuel->cadre->Lib_Cadre_FR ?? 'N/A' }}
                        @endif
                    </p>
                    <p class="mb-2">
                        <strong>Grade:</strong>
                        {{ $emp->gradeActuel?->id_grade ?? 'N/A' }}
                        @if($emp->gradeActuel?->grade)
                            - {{ $emp->gradeActuel->grade->Lib_grade_FR ?? 'N/A' }}
                        @endif
                    </p>
                    <p class="mb-0">
                        <strong>Echelon:</strong>
                        {{ $emp->echelonActuel?->id_ech ?? 'N/A' }}
                        @if($emp->echelonActuel?->echelon)
                            - {{ $emp->echelonActuel->echelon->COD_ECH ?? 'N/A' }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-header bg-secondary text-white py-2">
            Diplomes
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Diplome ID</th>
                        <th>Nom diplome</th>
                        <th>Specialite</th>
                        <th>Date obtention</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($emp->diplomes as $diplome)
                        <tr>
                            <td>{{ $diplome->id_diplome ?? 'N/A' }}</td>
                            <td>{{ $diplome->LL_DIPP ?? $diplome->type_dip ?? 'N/A' }}</td>
                            <td>{{ $diplome->LL_DIPS ?? $diplome->specialite_montion ?? 'N/A' }}</td>
                            <td>{{ optional($diplome->date_obtenue)->format('d/m/Y') ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Aucun diplome trouve.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white py-2">Historique cadres</div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Cadre</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($emp->cadreHistory as $item)
                                <tr>
                                    <td>{{ $item->id_cadre ?? 'N/A' }}</td>
                                    <td>{{ $item->cadre?->Lib_Cadre_FR ?? 'N/A' }}</td>
                                    <td>{{ optional($item->DT_AFF_Cadr)->format('d/m/Y') ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Aucun historique.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white py-2">Historique grades</div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Grade</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($emp->gradeHistory as $item)
                                <tr>
                                    <td>{{ $item->id_grade ?? 'N/A' }}</td>
                                    <td>{{ $item->grade?->Lib_grade_FR ?? ($item->LIBELLE_GRADE ?? 'N/A') }}</td>
                                    <td>{{ optional($item->DAT_EFF_GR)->format('d/m/Y') ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Aucun historique.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white py-2">Historique echelons</div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Echelon</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($emp->echelonHistory as $item)
                                <tr>
                                    <td>{{ $item->id_ech ?? 'N/A' }}</td>
                                    <td>{{ $item->echelon?->COD_ECH ?? 'N/A' }}</td>
                                    <td>{{ optional($item->DAT_EFF_ELO)->format('d/m/Y') ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Aucun historique.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white py-2">
            Historique affectations
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Affectation ID</th>
                        <th>Etablissement</th>
                        <th>Fonction</th>
                        <th>Date debut</th>
                        <th>Mode</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($emp->affectations as $aff)
                        <tr>
                            <td>{{ $aff->id_aff ?? 'N/A' }}</td>
                            <td>
                                {{ $aff->etablissement_id ?? 'N/A' }}
                                @if($aff->etablissement)
                                    - {{ $aff->etablissement->LIBELLE_FR_AFF ?? 'N/A' }}
                                @endif
                            </td>
                            <td>
                                {{ $aff->fonction_id ?? 'N/A' }}
                                @if($aff->fonction)
                                    - {{ $aff->fonction->LIB_FONCTION_FR ?? 'N/A' }}
                                @endif
                            </td>
                            <td>{{ optional($aff->DATE_DEBUT_AFF)->format('d/m/Y') ?? 'N/A' }}</td>
                            <td>{{ $aff->Mode_Affectation ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Aucune affectation trouvee.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
