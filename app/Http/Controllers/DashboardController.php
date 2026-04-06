<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employer;
use App\Models\Etablisement;
use App\Models\Absence;
use App\Models\Affectation;
use App\Models\Grade;
use App\Models\Region;
use App\Models\Diplome;
use App\Models\Enfant;
use App\Models\EmployeSituationStatutaireHistory;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── KPI Cards ──────────────────────────────────────────────
        $totalEmployes       = Employer::count();
        $totalEtablissements = Etablisement::count();

        $absencesMois = Absence::whereMonth('date_debut', now()->month)
                                ->whereYear('date_debut',  now()->year)
                                ->count();

        $congesEnCours = Absence::whereNotNull('congee_id')
                                 ->where('date_debut', '<=', now())
                                 ->where('date_fin',   '>=', now())
                                 ->count();

        $departsRetraite = EmployeSituationStatutaireHistory::whereBetween(
            'DATE_PREV_RETRAITE', [now(), now()->addYear()]
        )->count();

        // ── Répartition par sexe ───────────────────────────────────
        $hommes = Employer::where('SEXE', 'M')->count();
        $femmes = Employer::where('SEXE', 'F')->count();

        // ── Répartition par cadre (top 5) ─────────────────────────
        $repartitionCadre = DB::table('employe_cadre_history')
            ->join('cadre', 'employe_cadre_history.id_cadre', '=', 'cadre.id_cadre')
            ->select(
                'cadre.Lib_Cadre_FR',
                DB::raw('COUNT(DISTINCT employe_cadre_history.code_agent) as total')
            )
            ->groupBy('cadre.id_cadre', 'cadre.Lib_Cadre_FR')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // ── Évolution effectifs par mois (année courante) ──────────
        $effectifsParMois = Employer::selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('mois')
            ->orderBy('mois')
            ->pluck('total', 'mois');

        // ── Dernières affectations ─────────────────────────────────
        // IMPORTANT : la relation dans Affectation.php s'appelle
        //             etablisement()  (un seul 's') — on respecte ce nom
        $dernieresAffectations = Affectation::with([
            'employer',
            'etablissement',   // ← un seul 's' — correspond à la méthode du modèle
            'fonction',
        ])
            ->latest('DT_AFF_POSTE')
            ->limit(5)
            ->get();

        // ── Absences récentes ──────────────────────────────────────
        $absencesRecentes = Absence::with(['employer', 'congee'])
            ->latest('date_debut')
            ->limit(5)
            ->get();

        // ── Répartition par région (via JOINs directs) ─────────────
        $parRegion = DB::table('region')
            ->leftJoin('province',     'province.CD_REG',        '=', 'region.CD_REG')
            ->leftJoin('commune',      'commune.CD_PRV',         '=', 'province.CD_PRV')
            ->leftJoin('etablisement', 'etablisement.cd_commune','=', 'commune.CD_COM')
            ->leftJoin('affectation',  'affectation.code_etab',  '=', 'etablisement.CD_ETAB')
            ->leftJoin('employer',     'employer.COD_AG',        '=', 'affectation.code_agent')
            ->select(
                'region.CD_REG',
                'region.LIB_REGION_FR',
                'region.LIB_REGION_AR',
                DB::raw('COUNT(DISTINCT employer.COD_AG) as total')
            )
            ->groupBy('region.CD_REG', 'region.LIB_REGION_FR', 'region.LIB_REGION_AR')
            ->orderByDesc('total')
            ->get();

        // ── Indicateurs supplémentaires ───────────────────────────
        $diplomesBacPlus5 = Diplome::where('TYPE_DIP', 'SCOLAIRE')->count();
        $enfantsTotal     = Enfant::count();
        $employes_maries  = Employer::where('Sit_Familiale', 'like', '%Mari%')->count();
        $gradesDistincts  = Grade::count();

        $retraite2ans = EmployeSituationStatutaireHistory::whereBetween(
            'DATE_PREV_RETRAITE', [now(), now()->addYears(2)]
        )->count();

        // ── Données graphiques pour Chart.js ──────────────────────
        $moisLabels    = ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];
        $effectifsData = [];
        for ($i = 1; $i <= 12; $i++) {
            $effectifsData[] = $effectifsParMois[$i] ?? 0;
        }

        return view('dashboard.index', compact(
            'totalEmployes', 'totalEtablissements', 'absencesMois',
            'congesEnCours', 'departsRetraite',
            'hommes', 'femmes',
            'repartitionCadre',
            'dernieresAffectations',
            'absencesRecentes',
            'parRegion',
            'diplomesBacPlus5', 'enfantsTotal', 'employes_maries',
            'gradesDistincts', 'retraite2ans',
            'moisLabels', 'effectifsData'
        ));
    }
}