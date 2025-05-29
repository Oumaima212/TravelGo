<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Airline::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // Utilisez paginate() au lieu de get()
        $airlines = $query->paginate(10); // Ajustez le nombre (10) pour le nombre d'éléments par page

        return view('contents.airlines', compact('airlines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('airline.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:airlines',
            'statut' => 'required|in:actif,inactif',
            'logo' => 'nullable|image'  // Validation pour le logo
        ]);

        $airline = new Airline();
        $airline->name = $request->input('name');
        $airline->code = $request->input('code');
        $airline->statut = $request->input('statut');

        // Gestion du logo
        if ($request->hasFile('logo')) {
            $airline->logo = $request->file('logo')->store('logos', 'public');
        }

        $airline->save();

        return redirect()->route('airlines.index')->with('success', 'Compagnie aérienne ajoutée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $airline = Airline::findOrFail($id);
        return view('airline.show', compact('airline'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $airline = Airline::findOrFail($id);
        return view('airline.edit', compact('airline'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:airlines,code,' . $id,  // Vérification d'unicité sauf pour l'ID actuel
            'statut' => 'required|in:actif,inactif',
            'logo' => 'nullable|image|max:1024'
        ]);

        $airline = Airline::findOrFail($id);
        $airline->name = $request->input('name');
        $airline->code = $request->input('code');
        $airline->statut = $request->input('statut');

        // Mettre à jour le logo si un nouveau est téléchargé
        if ($request->hasFile('logo')) {
            $airline->logo = $request->file('logo')->store('logos', 'public');
        }

        $airline->save();

        return redirect()->route('airlines.index')->with('success', 'Compagnie aérienne mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $airline = Airline::findOrFail($id);
        $airline->delete();

        return redirect()->route('airlines.index')->with('success', 'Compagnie aérienne supprimée avec succès.');
    }
}
