
@extends('layouts.master')
@section('main')
    <div class="mb-3 d-flex justify-content-end ">
        <a href="{{ route('employers.cv.export', $Employer->COD_AG) }}" class="  btn btn-primary">
            Export CV
        </a>
    </div>
    @php
        $emp = $Employer;
        $photo = $emp->photo ? "storage/".$emp->photo: "images/avatar-default.svg";

        $fullName = trim((string) ($emp->NOM_PRENOM_FR ?? ''));
        $nameParts = preg_split('/\s+/', $fullName, 2) ?: [];
        $nom = $nameParts[0] ?? $fullName;
        $prenom = $nameParts[1] ?? '';
    @endphp



    {{-- ══════════════════════════ EN-TÊTE ══════════════════════════ --}}
    <div class="header">
        <div class="header-accent"></div>
        <div class="header-inner">
            <table class="headers-table">
                <tr>
                    {{-- Photo --}}
                    <td class="header-photo">
                        @if($photo)
                            <div class="profile-container">

                                <img src="{{ asset($photo) }}" class="profile-img" alt="Photo">

                                <form action="{{ route('employers.photo.update', $Employer->COD_AG) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <label for="upload-photo" class="upload-icon">
                                        +
                                    </label>

                                    <input type="file" id="upload-photo" name="photo" hidden onchange="this.form.submit()">
                                </form>
                            </div>
                        @else
                                <div class="photo-placeholder"></div>
                            @endif
                    </td>

                    {{-- Infos --}}
                    <td class="header-info">
                        <div class="h1" style="font-size:22px; font-weight:bold; color:#fff; margin-bottom:5px;">
                            {{ $fullName ?: 'N/A' }}
                        </div>

                        @if($emp->affectationActuelle?->fonction)
                            <div class="fonction">
                                {{ $emp->affectationActuelle->fonction->LIB_FONCTION_FR ?? '' }}
                            </div>
                        @endif
                        <div class="contact">&#9993; {{ $emp->ADRESSE_ELEC ?? 'N/A' }}</div>
                        <div class="contact">&#9742; {{ $emp->TEL_PORTABLE ?? $emp->TEL_FIXE ?? 'N/A' }}</div>
                    </td>

                    {{-- Logo --}}
                    @php
                        $logoPath = public_path('images/cv/logo.png'); // ← mettez votre logo ici
                        $logoBase64 = null;
                        if (file_exists($logoPath)) {
                            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
                        }
                    @endphp
                    <td class="header-right">
                        @if($logoBase64)
                            <img src="{{ $logoBase64 }}" alt="Logo">
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="green-stripe"></div>

    {{-- ══════════════════════════ INFOS PERSONNELLES ══════════════════════════ --}}
    <div class="section">
        <div class="section-title title-blue">&#9673; Informations personnelles</div>
        <table class="info-grid">
            <tr>
                <td><span class="label">Nom</span><strong>{{ $nom ?: 'N/A' }}</strong></td>
                <td><span class="label">Prénom</span><strong>{{ $prenom ?: 'N/A' }}</strong></td>
            </tr>
            <tr>
                <td><span class="label">Téléphone</span><strong>{{ $emp->TEL_PORTABLE ?? $emp->TEL_FIXE ?? 'N/A' }}</strong>
                </td>
                <td><span class="label">Email</span><strong>{{ $emp->ADRESSE_ELEC ?? 'N/A' }}</strong></td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="label">Adresse</span>
                    <strong>{{ $emp->ADRESSE_FR ?? $emp->ADRESSE_AR ?? 'N/A' }}</strong>
                </td>
            </tr>
        </table>
    </div>

    {{-- ══════════════════════════ AFFECTATION + STATUT ══════════════════════════ --}}
    <div class="section">
        <table class="two-col-table">
            <tr>
                <td>
                    <div class="section-title title-blue">&#9673; Affectation actuelle</div>
                    <div class="card-inner">
                        @php $currentAff = $emp->affectationActuelle; @endphp
                        @if($currentAff)
                            <p><strong>Établissement :</strong>
                                {{ $currentAff->code_etab ?? 'N/A' }}
                                @if($currentAff->etablissement)
                                    — {{ $currentAff->etablissement->NOM_ETAB ?? '' }}
                                @endif
                            </p>
                            <p><strong>Fonction :</strong>
                                {{ $currentAff->fonction_id ?? 'N/A' }}
                                @if($currentAff->fonction)
                                    — {{ $currentAff->fonction->LIB_FONCTION_FR ?? '' }}
                                @endif
                            </p>
                            <p><strong>Date début :</strong>
                                {{ optional($currentAff->DATE_DEBUT_AFF)->format('d/m/Y') ?? 'N/A' }}
                            </p>
                        @else
                            <p class="empty-msg">Aucune affectation actuelle.</p>
                        @endif
                    </div>
                </td>
                <td>
                    <div class="section-title title-blue">&#9673; Statut actuel</div>
                    <div class="card-inner">
                        <p><strong>Cadre :</strong>
                            {{ $emp->cadreActuel?->id_cadre ?? 'N/A' }}
                            @if($emp->cadreActuel?->cadre)
                                — {{ $emp->cadreActuel->cadre->Lib_Cadre_FR ?? '' }}
                            @endif
                        </p>
                        <p><strong>Grade :</strong>
                            {{ $emp->gradeActuel?->id_grade ?? 'N/A' }}
                            @if($emp->gradeActuel?->grade)
                                — {{ $emp->gradeActuel->grade->Lib_grade_FR ?? '' }}
                            @endif
                        </p>
                        <p><strong>Échelon :</strong>
                            {{ $emp->echelonActuel?->id_ech ?? 'N/A' }}
                            @if($emp->echelonActuel?->echelon)
                                — {{ $emp->echelonActuel->echelon->COD_ECH ?? '' }}
                            @endif
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- ══════════════════════════ DIPLÔMES ══════════════════════════ --}}
    <div class="section">
        <div class="section-title title-grey">&#9673; Diplômes</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom du diplôme</th>
                    <th>motion</th>
                    <th>type diplôme</th>
                    <th>Date obtention</th>
                    <th>PDF</th>
                </tr>
            </thead>
            <tbody>
                @forelse($emp->diplomes as $diplome)
                    <tr>
                        <td>{{ $diplome->id_diplome ?? 'N/A' }}</td>
                        <td>{{ $diplome->LL_DIP ?? $diplome->type_dip ?? 'N/A' }}</td>
                        <td>{{ $diplome->montion ?? 'N/A' }}</td>
                        <td>{{ $diplome->type_dip }}</td>
                        <td>{{ optional($diplome->date_obtenue)->format('d/m/Y') ?? 'N/A' }}</td>
                        @if ($diplome->PDF && file_exists(public_path('storage/diplomes/' . $diplome->PDF)))
                            <td>
                                <a class="btn btn-sm btn-outline-danger" href="{{ asset('storage/diplomes/' . $diplome->PDF) }}"
                                    target="_blank">

                                    <i class="fa fa-file-pdf"></i> Voir PDF
                                </a>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-msg">Aucun diplôme trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ══════════════════════════ HISTORIQUES ══════════════════════════ --}}
    <div class="section">
        <div class="section-title title-dark">&#9673; Historique cadres / grades / échelons</div>
        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <td style="width:33%; vertical-align:top; padding-right:5px;">
                    <table class="data-table">
                        <thead>
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
                                    <td>{{ optional($item->DT_AFF_Cadre)->format('d/m/Y') ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="empty-msg">Aucun.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </td>
                <td style="width:33%; vertical-align:top; padding-right:5px;">
                    <table class="data-table">
                        <thead>
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
                                    <td colspan="3" class="empty-msg">Aucun.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </td>
                <td style="width:34%; vertical-align:top;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Échelon</th>
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
                                    <td colspan="3" class="empty-msg">Aucun.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    {{-- ══════════════════════════ HISTORIQUE AFFECTATIONS ══════════════════════════ --}}
    <div class="section">
        <div class="section-title title-green">&#9673; Historique des affectations</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Établissement</th>
                    <th>Fonction</th>
                    <th>Date début</th>
                    <th>Mode</th>
                </tr>
            </thead>
            <tbody>
                @forelse($emp->affectations as $aff)
                    <tr>
                        <td>{{ $aff->id_aff ?? 'N/A' }}</td>
                        <td>
                            {{ $aff->code_etab ?? 'N/A' }}
                            @if($aff->etablissement)
                                — {{ $aff->etablissement->NOM_ETAB ?? '' }}
                            @endif
                        </td>
                        <td>
                            {{ $aff->fonction_id ?? 'N/A' }}
                            @if($aff->fonction)
                                — {{ $aff->fonction->LIB_FONCTION_FR ?? '' }}
                            @endif
                        </td>
                        <td>{{ optional($aff->DATE_DEBUT_AFF)->format('d/m/Y') ?? 'N/A' }}</td>
                        <td>{{ $aff->Mode_Affectation ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-msg">Aucune affectation trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection

