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
            color: #333;
            line-height: 1.5;
        }

        /* ── En-tête ── */
        .header {
            background: blue;
            color: white;
            padding: 20px;
            margin-bottom: 16px;
        }
        .header-table { width: 100%; }
        .header-photo { width: 100px; vertical-align: top; }
        .header-photo img {
            width: 90px;
            height: 110px;
            object-fit: cover;
            border: 3px solid white;
            border-radius: 4px;
        }
        .header-info { vertical-align: top; padding-left: 16px; }
        .header-info h1 { font-size: 20px; font-weight: bold; margin-bottom: 4px; }
        .header-info p  { font-size: 11px; color: #ccc; margin-bottom: 2px; }

        /* ── Sections ── */
        .section { margin-bottom: 14px; }
        .section-title {
            background: blue;
            color: white;
            font-size: 12px;
            font-weight: bold;
            padding: 5px 10px;
            margin-bottom: 8px;
            border-radius: 2px;
        }
        .section-title.dark    { background: #2c3e50; }
        .section-title.success { background: #27ae60; }
        .section-title.info    { background: #16a085; }
        .section-title.grey    { background: #7f8c8d; }

        /* ── Grille infos ── */
        .info-grid { width: 100%; }
        .info-grid td {
            width: 50%;
            padding: 4px 8px;
            vertical-align: top;
            border-bottom: 1px solid #eee;
        }
        .info-grid .label {
            font-size: 9px;
            color: #888;
            display: block;
        }
        .info-grid strong { font-size: 11px; }

        /* ── Tableaux ── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        .data-table th {
            background: #ecf0f1;
            padding: 5px 8px;
            text-align: left;
            border: 1px solid #ddd;
            font-weight: bold;
        }
        .data-table td {
            padding: 4px 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        .data-table tr:nth-child(even) td { background: #f9f9f9; }
        .empty-msg {
            text-align: center;
            color: #aaa;
            font-style: italic;
            padding: 8px;
        }

        /* ── Statut (2 colonnes côte à côte) ── */
        .two-col-table { width: 100%; }
        .two-col-table td { width: 50%; vertical-align: top; padding-right: 10px; }

        .card-inner {
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 10px;
            font-size: 10px;
        }
        .card-inner p { margin-bottom: 5px; }

        /* ── Pied de page ── */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0; right: 0;
            font-size: 9px;
            color: #aaa;
            border-top: 1px solid #eee;
            padding: 4px 20px;
            text-align: center;
        }
        .page-break { page-break-after: always; }
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
    Document généré le {{ now()->format('d/m/Y à H:i') }} — Confidentiel RH
</div>

{{-- ══════════════════════════ EN-TÊTE ══════════════════════════ --}}
<div class="header">
    <table class="header-table">
        <tr>
            <td class="header-photo">
                @if($photoBase64)
                    <img src="{{ $photoBase64 }}" alt="Photo">
                @endif
            </td>
            <td class="header-info">
                <h1>{{ $fullName ?: 'N/A' }}</h1>
                @if($emp->affectationActuelle?->fonction)
                    <p style="color:#f39c12; font-weight:bold;">
                        {{ $emp->affectationActuelle->fonction->LIB_FONCTION_FR ?? '' }}
                    </p>
                @endif
                <p>{{ $emp->ADRESSE_ELEC ?? '' }}</p>
                <p>{{ $emp->TEL_PORTABLE ?? $emp->TEL_FIXE ?? '' }}</p>
            </td>
        </tr>
    </table>
</div>

{{-- ══════════════════════════ INFOS PERSONNELLES ══════════════════════════ --}}
<div class="section">
    <div class="section-title">Informations personnelles</div>
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
            <td colspan="2"><span class="label">Adresse</span><strong>{{ $emp->ADRESSE_FR ?? $emp->ADRESSE_AR ?? 'N/A' }}</strong></td>
        </tr>
    </table>
</div>

{{-- ══════════════════════════ AFFECTATION + STATUT ══════════════════════════ --}}
<div class="section">
    <table class="two-col-table">
        <tr>
            <td>
                <div class="section-title">Affectation actuelle</div>
                <div class="card-inner">
                    @php $currentAff = $emp->affectationActuelle; @endphp
                    @if($currentAff)
                        <p><strong>Établissement :</strong>
                            {{ $currentAff->CD_ETAB ?? 'N/A' }}
                            @if($currentAff->etablissement)
                                — {{ $currentAff->etablissement->LIBELLE_FR_AFF ?? '' }}
                            @endif
                        </p>
                        <p><strong>Fonction :</strong>
                            {{ $currentAff->CODE_FONCTION ?? 'N/A' }}
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
                <div class="section-title info">Statut actuel</div>
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
    <div class="section-title grey">Diplômes</div>
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
    <div class="section-title dark">Historique cadres / grades / échelons</div>
    <table class="two-col-table" style="vertical-align:top;">
        <tr>
            {{-- Cadres --}}
            <td style="width:33%; padding-right:6px;">
                <table class="data-table">
                    <thead><tr><th>ID</th><th>Cadre</th><th>Date</th></tr></thead>
                    <tbody>
                        @forelse($emp->cadreHistory as $item)
                            <tr>
                                <td>{{ $item->id_cadre ?? 'N/A' }}</td>
                                <td>{{ $item->cadre?->Lib_Cadre_FR ?? 'N/A' }}</td>
                                <td>{{ optional($item->DT_AFF_Cadr)->format('d/m/Y') ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="empty-msg">Aucun.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </td>
            {{-- Grades --}}
            <td style="width:33%; padding-right:6px;">
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
            {{-- Échelons --}}
            <td style="width:33%;">
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
    <div class="section-title success">Historique des affectations</div>
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