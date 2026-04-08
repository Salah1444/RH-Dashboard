<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Commune;
use App\Models\Position;
use Illuminate\Support\Str;
use App\Models\Cadre;
use App\Models\Grade;
use App\Models\Echelon;
use App\Models\SituationStatutaire;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployerController extends Controller
{
    public function index(Request $request)
    {
        $query = Employer::with(['position', 'commune']);

        // Filtres
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('NOM_PRENOM_FR', 'like', "%$search%")
                    ->orWhere('CIN', 'like', "%$search%")
                    ->orWhere('COD_AG', 'like', "%$search%");
            });
        }
        if ($request->filled('sexe')) {
            $query->where('SEXE', $request->sexe);
        }
        if ($request->filled('position_id')) {
            $query->where('position_id', $request->position_id);
        }

        $employes  = $query->latest()->paginate(15)->withQueryString();
        $positions = Position::all();
        $total     = Employer::count();
        $hommes    = Employer::where('SEXE', 'M')->count();
        $femmes    = Employer::where('SEXE', 'F')->count();

        return view('employes.index', compact('employes', 'positions', 'total', 'hommes', 'femmes'));
    }

    public function create()
    {
        $communes   = Commune::orderBy('LIB_COMMUNE_FR')->get();
        $positions  = Position::all();
        return view('employes.create', compact('communes', 'positions'));
    }

    public function store(Request $request)
    {
        preg_match('/([A-Za-z]+)(\d+)/', $request->CIN, $matches);
        $validated = $request->validate([
            'CIN'           => 'required|string|max:20|unique:employer,CIN',
            'NOM_PRENOM_FR' => 'required|string|max:200',
            'NOM_PRENOM_AR' => 'nullable|string|max:200',
            'DATE_NAISS'    => 'nullable|date',
            'LIEU_NAISS'=>"required|string",
            'SEXE'          => 'nullable|in:M,F',
            'TEL_PORTABLE'  => 'nullable|string|max:20',
            'ADRESSE_ELEC'  => 'nullable|email|max:150',
            'RIB'=>'required',
            'ADRESSE_FR'=>'nullable|string',
            'ADRESSE_AR'=>'nullable|string',
            'TEL_FIXE'=>'nullable|string|max:20',
            'Sit_Familiale' => 'nullable|string|max:100',
            'ville_id'      => 'nullable|exists:commune,CD_COM',
            'position_id'   => 'nullable|exists:position,COD_POS',
            'photo'         => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        } else {
            $validated['photo'] = 'default.png';
        };

        $validated['CIN_A'] = $matches[1] ?? null;
        $validated['CIN_N'] = $matches[2] ?? null;

        Employer::create($validated);
        return redirect()->route('employes.index')
            ->with('success', 'Employé créé avec succès.');
    }

    public function show($id)
    {

        $employer = Employer::with([
            'commune.province.region',
            'position',
            'affectations.etablissement.commune.province.region',
            'affectations.fonction',
            'affectationActuelle.etablissement.commune.province.region',
            'affectationActuelle.fonction',
            'cadreHistories.cadre',
            'cadreActuel.cadre',
            'gradeHistories.grade',
            'gradeActuel.grade',
            'echelonHistories.echelon',
            'echelonActuel.echelon',
            'situationStatutaireHistories.situationStatutaire',
            'situationStatutaireActuelle.situationStatutaire',
            'conjoints',
            'enfants.garde',
            'diplomes',
            'absences.congee',
        ])->findOrFail($id);

        return view('employes.show', compact('employer'));
    }

    public function edit($id)
    {
        $employer = Employer::findOrFail($id);
        $communes  = Commune::orderBy('LIB_COMMUNE_FR')->get();
        $positions = Position::all();

        return view('employes.edit', compact('employer', 'communes', 'positions'));
    }

    public function update(Request $request, Employer $employer, $id)
    {

        
        $validated = $request->validate([
            'CIN'           => 'required|string|max:20',
            'NOM_PRENOM_FR' => 'required|string|max:200',
            'NOM_PRENOM_AR' => 'nullable|string|max:200',
            'DATE_NAISS'    => 'nullable|date',
            'SEXE'          => 'nullable|in:M,F',
            'RIB'=>'required',
            'ADRESSE_FR'=>'nullable|string',
            'ADRESSE_AR'=>'nullable|string',
            'TEL_PORTABLE'  => 'nullable|string|max:20',
            'ADRESSE_ELEC'  => 'nullable|email|max:150',
            'Sit_Familiale' => 'nullable|string|max:100',
            'ville_id'      => 'nullable|exists:commune,CD_COM',
            'position_id'   => 'nullable|exists:position,COD_POS',
            'photo'         => 'nullable|image|max:2048',
        ]);
        preg_match('/([A-Za-z]+)(\d+)/', $request->CIN, $matches);
         $validated['CIN_A'] = $matches[1] ?? null;
        $validated['CIN_N'] = $matches[2] ?? null;
        
        if ($request->hasFile('photo')) {
            if ($employer->photo && $employer->photo !== 'default.png') {
                Storage::disk('public')->delete($employer->photo);
            }
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }
        $employer = Employer::findOrFail($id);
        $employer->update($validated);
        return redirect()->route('employes.show', $id)
            ->with('success', 'Employé mis à jour.');
    }

    public function destroy(Employer $employer)
    {
        if ($employer->photo && $employer->photo !== 'default.png') {
            Storage::disk('public')->delete($employer->photo);
        }
        $employer->delete();
        return redirect()->route('employes.index')
            ->with('success', 'Employé supprimé.');
    }
    public function exportCV($id)
    {
        $Employer = Employer::with([
            'commune.province.region',
            'position',
            'affectations.etablissement.commune.province.region',
            'affectations.fonction',
            'affectationActuelle.etablissement.commune.province.region',
            'affectationActuelle.fonction',
            'cadreHistories.cadre',
            'cadreActuel.cadre',
            'gradeHistories.grade',
            'gradeActuel.grade',
            'echelonHistories.echelon',
            'echelonActuel.echelon',
            'situationStatutaireHistories.situationStatutaire',
            'situationStatutaireActuelle.situationStatutaire',
            'conjoints',
            'enfants.garde',
            'diplomes',
            'absences.congee',
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

        $pdf = Pdf::loadView('employes.cv_pdf', [
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
}
