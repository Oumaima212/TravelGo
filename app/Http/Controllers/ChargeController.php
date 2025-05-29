<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use Illuminate\Http\Request;

class ChargeController extends Controller
{
    /**
     * Afficher la liste des charges.
     */
    public function index(Request $request)
    {
        $query = Charge::query(); // Initialiser la requête

        // Filtrer si un paramètre de recherche est fourni
        if ($request->has('search') && !empty($request->search)) {
            $query->where('nom', 'like', '%' . $request->search . '%')
                  ->orWhere('type_charge', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Récupérer toutes les charges après filtrage
        $charges = $query->paginate(10); // Paginer les résultats (10 par page)

        return view('contents.charges', compact('charges')); // Passer les données à la vue
    }



    /**
     * Afficher le formulaire pour créer une nouvelle charge.
     */
    public function create()
    {
    }

    /**
     * Enregistrer une nouvelle charge.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type_charge' => 'required|string|max:255',
            'montant' => 'required|numeric',
            'date_charge' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Charge::create($request->all()); // Créer une nouvelle charge
        return redirect()->route('charges.index')->with('success', 'Charge ajoutée avec succès.');
    }

    /**
     * Afficher une charge spécifique.
     */
    public function show($id)
    {

    }

    /**
     * Afficher le formulaire pour modifier une charge.
     */
    public function edit($id)
    {
    }

    /**
     * Mettre à jour une charge existante.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'type_charge' => 'required|string|max:255',
            'montant' => 'required|numeric',
            'date_charge' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $charge = Charge::findOrFail($id);
        $charge->update($request->all()); // Mettre à jour les données
        return redirect()->route('charges.index')->with('success', 'Charge mise à jour avec succès.');
    }

    /**
     * Supprimer une charge.
     */
    public function destroy($id)
    {
        $charge = Charge::findOrFail($id);
        $charge->delete(); // Supprimer la charge
        return redirect()->route('charges.index')->with('success', 'Charge supprimée avec succès.');
    }
}
