<?php

namespace App\Http\Controllers;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Client;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    // Récupérer la liste des clients
    $clients = Client::all();

    // Créer une requête pour les paiements
    $query = Payment::query();

    // Ajouter un filtre si un client est sélectionné
    if ($request->filled('idClient')) {
        $query->where('idClient', $request->idClient);
    }

    // Ajouter un filtre si un mode de paiement est sélectionné
    if ($request->filled('method')) {
        $query->where('method', $request->method);
    }

    // Obtenir les paiements paginés
    $payments = $query->paginate(10);

    // Retourner la vue avec les données
    return view('contents.payement', compact('clients', 'payments'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'idClient' => 'required|exists:clients,idClient',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'method' => 'required|string|in:espece,virement,cheque,carte_credit',
            'status' => 'required|string|in:pending,completed,failed',
            'transactionNumber' => 'required|string|unique:payments,transactionNumber',
        ]);

        // Création du paiement
        Payment::create($validated);

        // Redirection avec un message de succès
        return redirect()->route('payement.index')->with('success', 'Paiement ajouté avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        // Validation des données
        $validated = $request->validate([
            'idClient' => 'required|exists:clients,idClient',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'method' => 'required|string|in:espece,virement,cheque,carte_credit',
            'status' => 'required|string|in:pending,completed,failed',
            'transactionNumber' => "required|string|unique:payments,transactionNumber,{$id}",
        ]);

        // Mise à jour du paiement
        $payment->update($validated);

        // Redirection avec un message de succès
        return redirect()->route('payement.index')->with('success', 'Paiement mis à jour avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        // Redirection avec un message de succès
        return redirect()->route('payement.index')->with('success', 'Paiement supprimé avec succès.');
    }
}
