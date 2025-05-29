<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     */
    public function index(Request $request)
    {
        // Récupère tous les utilisateurs avec les colonnes 'id', 'name', et 'role'
        $users = User::all(['id', 'name', 'role']);

        // Récupère la valeur de la recherche
        $search = $request->input('search');

        // Applique un filtre sur le modèle 'Service' si une recherche est faite
        $services = Service::with(['prestataire'])
            ->when($search, function ($query, $search) {
                // Applique la condition 'like' si une recherche est spécifiée
                return $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10); // Ajoute la pagination

        // Retourne la vue avec les services et les utilisateurs
        return view('contents.service', compact('services', 'users'));
    }



    /**
     * Store a newly created service in storage.
     */
   // App\Http\Controllers\ServiceController.php
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prestataire' => 'required|exists:users,id', // Assurez-vous que l'utilisateur existe
            'type' => 'required|string',
            'price' => 'required|numeric',
        ]);

        Service::create([
            'name' => $validated['name'],
            'prestataire_id' => $validated['prestataire'],
            'type' => $validated['type'],
            'price' => $validated['price'],
        ]);

        return redirect()->route('service.index')->with('success', 'Service ajouté avec succès');
    }

}
