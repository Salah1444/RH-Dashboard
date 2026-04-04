<?php

namespace App\Http\Controllers;

use App\Models\Congee;
use Illuminate\Http\Request;

class CongeeController extends Controller
{
    public function index()
    {
        $congees = Congee::withCount('absences')->latest()->paginate(15);
        return view('congees.index', compact('congees'));
    }

    public function create()
    {
        return view('congees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_congee' => 'required|string|max:100',
            'date_debut'  => 'required|date',
            'date_fin'    => 'required|date|after_or_equal:date_debut',
            'nombre_jrs'  => 'nullable|integer|min:1',
        ]);

        // Auto-calculate days if not provided
        if (empty($validated['nombre_jrs'])) {
            $validated['nombre_jrs'] = \Carbon\Carbon::parse($validated['date_debut'])
                ->diffInDays(\Carbon\Carbon::parse($validated['date_fin'])) + 1;
        }

        Congee::create($validated);
        return redirect()->route('congees.index')->with('success', 'Congé créé.');
    }

    public function edit(Congee $congee)
    {
        return view('congees.create', compact('congee'));
    }

    public function update(Request $request, Congee $congee)
    {
        $validated = $request->validate([
            'type_congee' => 'required|string|max:100',
            'date_debut'  => 'required|date',
            'date_fin'    => 'required|date|after_or_equal:date_debut',
            'nombre_jrs'  => 'nullable|integer|min:1',
        ]);

        if (empty($validated['nombre_jrs'])) {
            $validated['nombre_jrs'] = \Carbon\Carbon::parse($validated['date_debut'])
                ->diffInDays(\Carbon\Carbon::parse($validated['date_fin'])) + 1;
        }

        $congee->update($validated);
        return redirect()->route('congees.index')->with('success', 'Congé mis à jour.');
    }

    public function destroy(Congee $congee)
    {
        $congee->delete();
        return redirect()->route('congees.index')->with('success', 'Congé supprimé.');
    }
}