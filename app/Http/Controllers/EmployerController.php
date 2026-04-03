<?php

namespace App\Http\Controllers;

use App\Exports\EmployersImportTemplate;
use App\Http\Requests\StoreEmployerRequest;
use App\Imports\EmployersImport;
use App\Models\Affectation;
use App\Models\Cadre;
use App\Models\Commune;
use App\Models\Employer;
use App\Models\Position;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class EmployerController extends Controller
{
    public function create(): View
    {
        $communes = Commune::query()
            ->orderBy('LIB_COMMUNE_FR')
            ->get(['CD_COM', 'LIB_COMMUNE_FR']);

        $positions = Position::query()
            ->orderBy('LIB_POSITION_FR')
            ->get(['COD_POS', 'LIB_POSITION_FR']);

        return view('employers.create', compact('communes', 'positions'));
    }

    public function store(StoreEmployerRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['photo']);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('employer-photos', 'public');
        } else {
            $data['photo'] = '';
        }

        /** @var Employer $employer */
        $employer = Employer::query()->create($data);

        return redirect()
            ->route('employers.show', $employer->COD_AG)
            ->with('success', __('employer_create.saved_success'));
    }

    public function importTemplate()
    {
        return Excel::download(new EmployersImportTemplate(), 'modele_import_employes.xlsx');
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        try {
            Excel::import(new EmployersImport, $request->file('file'));
        } catch (\Throwable $e) {
            return back()->withErrors([
                'file' => 'Échec de l’import : '.$e->getMessage(),
            ]);
        }

        return back()->with('success', __('employer_create.import_success'));
    }
    public function index(Request $request)
    {
        // ── Listes pour les filtres ────────────────────────────────
        $regions = Affectation::query()
            ->with('etablissement.commune.province.region')
            ->get()
            ->map(fn($a) => $a->etablissement?->commune?->province?->region?->LIB_REGION_FR)
            ->filter()
            ->unique()
            ->sort()
            ->values();
        $cadres = Cadre::orderBy('Lib_Cadre_FR')->pluck('Lib_Cadre_FR');
        $situationsFamiliales = Employer::whereNotNull('Sit_Familiale')
            ->distinct()
            ->orderBy('Sit_Familiale')
            ->pluck('Sit_Familiale');

        // ── Requête principale paginée ─────────────────────────────
        $Employer = Employer::query()
            ->with([
                'affectationActuelle.etablissement.commune.province.region',
                'affectationActuelle.fonction',
                'cadreActuel.cadre',
                'gradeActuel.grade',
                'situationStatutaireActuelle.situationStatutaire',
            ])
            ->orderBy('NOM_PRENOM_FR')
            ->paginate(15)
            ->withQueryString();
        // ── Stats rapides ──────────────────────────────────────────
        $stats = [
            'total'     => Employer::count(),
            'hommes'    => Employer::where('SEXE', 'M')->count(),
            'femmes'    => Employer::where('SEXE', 'F')->count(),
            'resultats' => $Employer->total(),
        ];

        return view('employers.index', compact(
            'Employer', 'regions', 'cadres', 'situationsFamiliales', 'stats'
        ));
    }
 public function exportCV($id)
{
    $Employer = Employer::with([
        'position',
        'affectationActuelle.etablissement',
        'affectationActuelle.fonction',
        'cadreActuel.cadre',
        'gradeActuel.grade',
        'echelonActuel.echelon',
        'diplomes',
        'cadreHistory.cadre',
        'gradeHistory.grade',
        'echelonHistory.echelon',
        'affectations.etablissement',
        'affectations.fonction',
    ])->findOrFail($id);

    $photoBase64 = null;

    if ($Employer->photo) {

        // Essayer plusieurs chemins possibles
        $possiblePaths = [
            storage_path('app/public/' . ltrim($Employer->photo, '/')),
            public_path('storage/' . ltrim($Employer->photo, '/')),
            public_path(ltrim($Employer->photo, '/')),
        ];

        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $photoData = base64_encode(file_get_contents($path));
                $photoMime = mime_content_type($path);
                $photoBase64 = "data:{$photoMime};base64,{$photoData}";
                break;
            }
        }
    }

    // Photo par défaut si aucune trouvée
    if (!$photoBase64) {
        $defaultPath = public_path('images/cv/avatar-default.jpg'); // PNG fonctionne mieux que SVG dans DomPDF
        if (file_exists($defaultPath)) {
            $photoData   = base64_encode(file_get_contents($defaultPath));
            $photoBase64 = "data:image/jpg;base64,{$photoData}";
        }
    }

    $pdf = Pdf::loadView('employers.cv_pdf', [
        'Employer'    => $Employer,
        'photoBase64' => $photoBase64,
    ])
    ->setPaper('a4', 'portrait')
    ->setOptions([
        'defaultFont'          => 'DejaVu Sans',
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled'      => false,
        'chroot'               => storage_path('app/public'), // ← permet l'accès aux fichiers locaux
    ]);

    $fileName = 'CV_' . Str::slug($Employer->NOM_PRENOM_FR ?? 'employe') . '_' . now()->format('Ymd') . '.pdf';

    return $pdf->download($fileName);
}
    public function show(int $id)
    {
        $Employer = Employer::with([
            'commune.province.region',
            'position',
            'affectations.etablissement.commune.province.region',
            'affectations.fonction',
            'affectationActuelle.etablissement.commune.province.region',
            'affectationActuelle.fonction',
            'cadreHistory.cadre',
            'cadreActuel.cadre',
            'gradeHistory.grade',
            'gradeActuel.grade',
            'echelonHistory.echelon',
            'echelonActuel.echelon',
            'situationStatutaireHistory.situationStatutaire',
            'situationStatutaireActuelle.situationStatutaire',
            'conjoints',
            'enfants.garde',
            'diplomes',
            'absences.congee',
        ])->findOrFail($id);

        return view('employers.show', compact('Employer'));
    }
}
