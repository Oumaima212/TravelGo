<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Accommodation;
use Illuminate\Http\Request;
use App\Models\Commission;

class AccommodationController extends Controller
{
    /**
     * Display a listing of the accommodations.
     */

    public function index(Request $request)
    {
        $users = User::all(['id', 'name', 'role']);
        $commissions = Commission::all(); // Récupérer toutes les commissions

        $search = $request->input('search');
        $hebergements = Accommodation::with(['commission', 'prestataire'])
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('location', 'like', "%{$search}%");
        })
        ->paginate(10);




        return view('contents.accommodation', compact('hebergements', 'users', 'commissions'));
    }


    /**
     * Store a newly created accommodation in storage.
     */
    public function store(Request $request)
{
    // Validation des données
    $validatedData = $request->validate([
        'prestataire' => 'required|exists:users,id', // On vérifie que le prestataire existe
        'name' => 'required|string|max:255',
        'distance' => 'required|string|max:255',
        'commission' => 'required|numeric',
        'type' => 'required|string|max:255',
        'address' => 'nullable|string',
        'email' => 'nullable|email',
        'phone' => 'nullable|string|max:20',
        'status' => 'required|in:actif,inactif',
        'dateJoined' => 'required|date',

    ]);

    // Récupérer le rôle de l'utilisateur (prestataire)
    $user = User::find($validatedData['prestataire']);
    $role = $user->role; // Récupère le rôle de l'utilisateur

    // Créer un nouvel hébergement avec le rôle de l'utilisateur
    Accommodation::create([
        'prestataire_id' => $validatedData['prestataire'], // ID du prestataire
        'commission_id' => $validatedData['commission'], // ID de la commission
        'name' => $validatedData['name'],
        'distance' => $validatedData['distance'],
        'type' => $validatedData['type'],
        'status' => $validatedData['status'],
        'dateJoined' => $validatedData['dateJoined'],
        'address' => $validatedData['address'] ?? 'N/A',
        'email' => $validatedData['email'],
        'phone' => $validatedData['phone'] ?? 'N/A',
    ]);



    return redirect()->route('accommodation.index')->with('status', 'Hébergement créé avec succès !');
}


    /**
     * Update the specified accommodation in storage.
     */
    public function update(Request $request, Accommodation $accommodation)
    {
        // Validate the request
        $validatedData = $request->validate([
            'prestataire' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'distance' => 'required|string|max:255',
            'commission' => 'required|numeric',
            'type' => 'required|string|max:255',
            'address' => $validatedData['address'] ?? $accommodation->address, // Use the existing address if not provided
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:actif,inactif',
            'dateJoined' => 'required|date',


        ]);

        // Update the accommodation
        $accommodation->update($validatedData);

        return redirect()->route('accommodation.index')->with('status', 'Hébergement mis à jour avec succès !');
    }
}

