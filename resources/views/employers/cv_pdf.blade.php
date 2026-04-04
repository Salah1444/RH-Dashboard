<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>CV {{ $Employer->NOM_PRENOM_FR }}</title>
    <style>
        
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1a1a2e;
            line-height: 1.5;
        }

        /* ══ COULEURS DU LOGO ══
           Bleu foncé  : #1a237e
           Bleu ciel   : #0288d1
           Vert        : #2e7d32
           Rouge       : #c62828
           Dégradé bg  : #0d47a1 → #1565c0
        */

        /* ── En-tête ── */
        .header {
            background: #0d47a1;
            color: white;
            padding: 0;
            margin-bottom: 16px;
            border-bottom: 4px solid #c62828;
        }
        .header-inner {
            padding: 20px;
        }
        .header-accent {
            height: 6px;
            background: #0288d1;
        }

        .header-table { width: 100%; }
        .header-photo { width: 110px; vertical-align: middle; }
        .header-photo img {
            width: 95px;
            height: 115px;
            object-fit: cover;
            border: 3px solid #0288d1;
            border-radius: 4px;
        }
        .header-photo .photo-placeholder {
            width: 95px;
            height: 115px;
            border: 3px solid #0288d1;
            border-radius: 4px;
            background: #1565c0;
        }
        .header-info { vertical-align: middle; padding-left: 18px; }
        .header-info h1 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #ffffff;
            letter-spacing: 0.5px;
        }
        .header-info .fonction {
            font-size: 12px;
            color: #90caf9;
            font-weight: bold;
            margin-bottom: 6px;
            border-left: 3px solid #c62828;
            padding-left: 8px;
        }
        .header-info .contact {
            font-size: 10px;
            color: #bbdefb;
            margin-bottom: 2px;
        }
        .header-right {
            vertical-align: middle;
            text-align: right;
            width: 80px;
        }
        .header-right img {
            width: 70px;
            opacity: 0.85;
        }

        /* ── Sections ── */
        .section { margin-bottom: 14px; }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            padding: 5px 12px;
            margin-bottom: 8px;
            border-radius: 2px;
            color: white;
            border-left: 5px solid rgba(255,255,255,0.4);
        }

        /* Variantes couleurs logo */
        .title-blue-dark { background: #1a237e; }
        .title-blue      { background: #0288d1; }
        .title-green     { background: #2e7d32; }
        .title-grey      { background: #546e7a; }
        .title-dark      { background: #1a237e; border-left-color: #0288d1; }

        /* ── Grille infos ── */
        .info-grid { width: 100%; border-collapse: collapse; }
        .info-grid td {
            width: 50%;
            padding: 5px 10px;
            vertical-align: top;
            border-bottom: 1px solid #e3f2fd;
        }
        .info-grid tr:nth-child(even) td { background: #f5f9ff; }
        .info-grid .label {
            font-size: 9px;
            color: #0288d1;
            font-weight: bold;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .info-grid strong { font-size: 11px; color: #1a237e; }

        /* ── Tableaux ── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        .data-table th {
            background: #1a237e;
            color: white;
            padding: 5px 8px;
            text-align: left;
            border: 1px solid #0d47a1;
            font-weight: bold;
        }
        .data-table td {
            padding: 4px 8px;
            border: 1px solid #e0e0e0;
            vertical-align: top;
            color: #333;
        }
        .data-table tr:nth-child(even) td { background: #e8f4fd; }
        .data-table tr:nth-child(odd)  td { background: #ffffff; }

        .empty-msg {
            text-align: center;
            color: #90a4ae;
            font-style: italic;
            padding: 8px;
        }

        /* ── Cards 2 colonnes ── */
        .two-col-table { width: 100%; border-collapse: collapse; }
        .two-col-table > tr > td {
            width: 50%;
            vertical-align: top;
            padding-right: 8px;
        }
        .two-col-table > tr > td:last-child { padding-right: 0; padding-left: 8px; }

        .card-inner {
            border: 1px solid #bbdefb;
            border-top: 3px solid #0288d1;
            border-radius: 2px;
            padding: 10px;
            font-size: 10px;
            background: #fafcff;
        }
        .card-inner p { margin-bottom: 5px; color: #333; }
        .card-inner strong { color: #1a237e; }

        /* ── Pied de page ── */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0; right: 0;
            font-size: 9px;
            color: #90a4ae;
            border-top: 2px solid #0288d1;
            padding: 4px 20px;
            text-align: center;
            background: white;
        }

        .page-break { page-break-after: always; }

        /* ── Bande décorative verte ── */
        .green-stripe {
            height: 3px;
            background: #2e7d32;
            margin-bottom: 14px;
        }
        .profile-container{
    position: relative;
    width: 120px;
    height: 120px;
}

.profile-img{
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #09A6ED;
}

.upload-icon{
    position: absolute;
    bottom: 0px;
    right: 10px;
    width: 20px;
    height: 20px;
    background: #09A6ED;
    color: white;
    border-radius: 50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
    cursor:pointer;
    border:2px solid white;
    transition:0.3s;
}

.upload-icon:hover{
    background:#0b87c4;
}
    </style>
</head>
<body>

@php
    $emp = $Employer;
    $fullName  = trim((string)($emp->NOM_PRENOM_FR ?? ''));
    $nameParts = preg_split('/\s+/', $fullName, 2) ?: [];
    $nom    = $nameParts[0] ?? $fullName;
    $prenom = $nameParts[1] ?? '';
@endphp

{{-- Pied de page fixe --}}
<div class="footer">
    Document généré le {{ now()->format('d/m/Y à H:i') }} &nbsp;|&nbsp; Confidentiel RH
</div>

{{-- ══════════════════════════ EN-TÊTE ══════════════════════════ --}}
<div class="header">
<<<<<<< HEAD
    <div class="header-accent"></div>
    <div class="header-inner">
        <table class="header-table">
            <tr>
                {{-- Photo --}}
                <td class="header-photo">
                    @if($photoBase64)
                        <img src="{{ $photoBase64 }}" alt="Photo">
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
                    <div class="contact">&#9993;  {{ $emp->ADRESSE_ELEC ?? 'N/A' }}</div>
                    <div class="contact">&#9742;  {{ $emp->TEL_PORTABLE ?? $emp->TEL_FIXE ?? 'N/A' }}</div>
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
            <td><span class="label">Téléphone</span><strong>{{ $emp->TEL_PORTABLE ?? $emp->TEL_FIXE ?? 'N/A' }}</strong></td>
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
                <th>Spécialité</th>
                <th>Date obtention</th>
            </tr>
        </thead>
        <tbody>
            @forelse($emp->diplomes as $diplome)
                <tr>
                    <td>{{ $diplome->id_diplome ?? 'N/A' }}</td>
                    <td>{{ $diplome->LL_DIP ?? $diplome->type_dip ?? 'N/A' }}</td>
                    <td>{{ $diplome->montion ?? 'N/A' }}</td>
                    <td>{{ optional($diplome->date_obtenue)->format('d/m/Y') ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="empty-msg">Aucun diplôme trouvé.</td></tr>
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
                    <thead><tr><th>ID</th><th>Cadre</th><th>Date</th></tr></thead>
                    <tbody>
                        @forelse($emp->cadreHistory as $item)
                            <tr>
                                <td>{{ $item->id_cadre ?? 'N/A' }}</td>
                                <td>{{ $item->cadre?->Lib_Cadre_FR ?? 'N/A' }}</td>
                                <td>{{ optional($item->DT_AFF_Cadre)->format('d/m/Y') ?? 'N/A' }}</td>

                            </tr>
                        @empty
                            <tr><td colspan="3" class="empty-msg">Aucun.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </td>

            <td style="width:33%; vertical-align:top; padding-right:5px;">

                <table class="data-table">
                    <thead><tr><th>ID</th><th>Grade</th><th>Date</th></tr></thead>
                    <tbody>
                        @forelse($emp->gradeHistory as $item)
                            <tr>
                                <td>{{ $item->id_grade ?? 'N/A' }}</td>
                                <td>{{ $item->grade?->Lib_grade_FR ?? ($item->LIBELLE_GRADE ?? 'N/A') }}</td>
                                <td>{{ optional($item->DAT_EFF_GR)->format('d/m/Y') ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="empty-msg">Aucun.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </td>
            <td style="width:34%; vertical-align:top;">

                <table class="data-table">
                    <thead><tr><th>ID</th><th>Échelon</th><th>Date</th></tr></thead>
                    <tbody>
                        @forelse($emp->echelonHistory as $item)
                            <tr>
                                <td>{{ $item->id_ech ?? 'N/A' }}</td>
                                <td>{{ $item->echelon?->COD_ECH ?? 'N/A' }}</td>
                                <td>{{ optional($item->DAT_EFF_ELO)->format('d/m/Y') ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="empty-msg">Aucun.</td></tr>
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
                            — {{ $aff->etablissement->LIBELLE_FR_AFF ?? '' }}
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
                <tr><td colspan="5" class="empty-msg">Aucune affectation trouvée.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>