@extends('layouts.master')

@section('main')
    <div class="container-fluid">

        <!-- Page Heading -->
       
            <!-- Page Heading -->
<div class="row mb-4">

    <!-- Total -->
    <div class="col-xl-4 col-md-4 mb-3">
        <div class="card border-0 text-white shadow"
             style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius:14px;">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="rounded-3 mr-2 d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:48px;height:48px;background:rgba(255,255,255,.2);font-size:1.3rem;">
                    <i class="fa fa-users"></i>
                </div>
                <div>
                    <div class="text-uppercase fw-semibold"
                         style="font-size:.7rem;letter-spacing:.07em;opacity:.85;">
                        Total employés
                    </div>
                    <div class="fw-bold" style="font-size:1.7rem;line-height:1.1;">
                        {{ $Employer->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hommes -->
    <div class="col-xl-4 col-md-4 mb-3">
        <div class="card border-0 text-white shadow"
             style="background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); border-radius:14px;">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="rounded-3 mr-2 d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:48px;height:48px;background:rgba(255,255,255,.2);font-size:1.3rem;">
                    <i class="fa fa-mars"></i>
                </div>
                <div>
                    <div class="text-uppercase fw-semibold"
                         style="font-size:.7rem;letter-spacing:.07em;opacity:.85;">
                        Hommes
                    </div>
                    <div class="fw-bold" style="font-size:1.7rem;line-height:1.1;">
                        {{ $Employer->where('SEXE','M')->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Femmes -->
    <div class="col-xl-4 col-md-4 mb-3">
        <div class="card border-0 text-white shadow"
             style="background: linear-gradient(135deg, #e74a8b 0%, #b5246a 100%); border-radius:14px;">
            <div class="card-body d-flex align-items-center gap-3 py-3">
                <div class="rounded-3 mr-2 d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:48px;height:48px;background:rgba(255,255,255,.2);font-size:1.3rem;">
                    <i class="fa fa-venus"></i>
                </div>
                <div>
                    <div class="text-uppercase fw-semibold"
                         style="font-size:.7rem;letter-spacing:.07em;opacity:.85;">
                        Femmes
                    </div>
                    <div class="fw-bold" style="font-size:1.7rem;line-height:1.1;">
                        {{ $Employer->where('SEXE','F')->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
        

        <!-- DataTables Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Liste des employés</h6>
            <div class="card-header py-3 d-flex flex-wrap align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Liste des employés</h6>
                <a href="{{ route('employers.create') }}" class="btn btn-sm btn-primary shadow-sm mt-2 mt-sm-0"
                   style="border-radius:10px;">
                    <i class="fas fa-user-plus mr-1"></i> Ajouter / import Excel
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                        <thead>
                            <tr>
                                <th>CODE</th>
                                <th>Employé</th>
                                <th>CIN</th>
                                <th>Genre</th>
                                <th>Sit. familiale</th>
                                <th>Cadre</th>
                                <th>Grade</th>
                                <th>Établissement</th>
                                <th>Région</th>
                                <th>Sit. statutaire</th>
                                <th>CV</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>CODE</th>
                                <th>Employé</th>
                                <th>CIN</th>
                                <th>Genre</th>
                                <th>Sit. familiale</th>
                                <th>Cadre</th>
                                <th>Grade</th>
                                <th>Établissement</th>
                                <th>Région</th>
                                <th>Sit. statutaire</th>
                                <th>CV</th>
                            </tr>
                        </tfoot>

                        <tbody>
                            @foreach($Employer as $i => $emp)
                                @php
                                    
                                    

                                    $aff = $emp->affectationActuelle;
                                    $cadre = $emp->cadreActuel?->cadre?->Lib_Cadre_FR;
                                    $grade = $emp->gradeActuel?->grade?->Lib_grade_FR;
                                    $sitStat = $emp->situationStatutaireActuelle?->situationStatutaire?->LIB_SITUATION_STATUTAIRE_FR;
                                    $region = $aff?->etablissement?->commune?->province?->region?->LIB_REGION_FR;
                                    $etab = $aff?->etablissement?->NOM_ETAB;
                                @endphp

                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            
                                            <div>
                                                <div class="fw-semibold">
                                                    {{ $emp->NOM_PRENOM_FR ?? '—' }}
                                                </div>
                                                @if($emp->NOM_PRENOM_AR)
                                                    <div class="arabic-name">
                                                        {{ $emp->NOM_PRENOM_AR }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        @if($emp->CIN)
                                            <code class="cin">{{ $emp->CIN }}</code>
                                        @else
                                            —
                                        @endif
                                    </td>

                                    <td>
                                        @if($emp->SEXE === 'M')
                                            <span class="text-primary">
                                                <i class="bi bi-gender-male"></i> Masculin
                                            </span>
                                        @elseif($emp->SEXE === 'F')
                                            <span class="text-danger">
                                                <i class="bi bi-gender-female"></i> Féminin
                                            </span>
                                        @endif
                                    </td>

                                    <td>{{ $emp->Sit_Familiale ?? '—' }}</td>

                                    <td>
                                        @if($cadre)
                                            <span >{{ $cadre }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($grade)
                                            <span >{{ $grade }}</span>
                                        @endif
                                    </td>

                                    <td>{{ $etab ?? '—' }}</td>

                                    <td>{{ $region ?? '—' }}</td>

                                    <td>
                                        @if($sitStat)
                                            <span class="badge bg-warning text-dark">{{ $sitStat }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('employers.show', $emp->COD_AG) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection