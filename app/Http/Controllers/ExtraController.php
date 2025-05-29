<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use Illuminate\Http\Request;

class ExtraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Vérification de la présence d'un terme de recherche dans la requête
        $search = $request->input('search');
        if ($search) {
            $extras = Extra::where('type', 'like', '%' . $search . '%')->paginate(10);
        } else {
            // Sinon, récupérer toutes les entrées
            $extras = Extra::paginate(10);
        }

        return view('contents.extra', compact('extras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données envoyées
        $validated = $request->validate([
            'type' => 'required|string|max:255',
        ]);

        // Création d'un nouvel "extra"
        Extra::create($validated);

        return redirect()->route('extra.index')->with('success', 'Extra créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Extra $extra)
    {
        return view('extras.show', compact('extra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Extra $extra)
    {
        return view('extras.edit', compact('extra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Extra $extra)
    {
        // Validation des données envoyées
        $validated = $request->validate([
            'type' => 'required|string|max:255',
        ]);

        // Mise à jour de l'extra
        $extra->update($validated);

        return redirect()->route('extra.index')->with('success', 'Extra mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Extra $extra)
    {
        // Suppression de l'extra
        $extra->delete();

        return redirect()->route('extra.index')->with('success', 'Extra supprimé avec succès.');
    }
}
