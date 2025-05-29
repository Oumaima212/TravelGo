<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Program;
use App\Models\Client;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // Récupérer les programmes et les clients pour les filtres
        $programs = Program::all();
        $clients = Client::all();

        // Filtrer les réservations selon les critères de recherche
        $query = Reservation::query()->with(['program', 'client']);

        // Filtrer par programme
        if ($request->has('program_id') && $request->program_id != '') {
            $query->where('program_id', $request->program_id);
        }

        // Filtrer par client
        if ($request->has('client_id') && $request->client_id != '') {
            $query->where('client_id', $request->client_id);
        }

        // Récupérer les réservations paginées
        $reservations = $query->paginate(10);

        // Retourner la vue avec les réservations, programmes et clients
        return view('contents.reservation', [
            'reservations' => $reservations,
            'programs' => $programs,
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new reservation.
     */
    public function create()
    {
        // Récupérer les programmes et les clients pour le formulaire
        $programs = Program::all();
        $clients = Client::all();

        return view('contents.reservation_create', [
            'programs' => $programs,
            'clients' => $clients,
        ]);
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request)
    {

        // Validation des données
        $request->validate([
            'client_id' => 'required|exists:clients,idClient',
            'program_id' => 'required|exists:programs,id',
            'reservation_date' => 'required|date',
        ]);

        // Récupérer le programme sélectionné pour obtenir le prix
        $program = Program::findOrFail($request->program_id);

        // Créer la réservation
        $reservation = new Reservation();
        $reservation->client_id = $request->client_id;
        $reservation->program_id = $request->program_id;
        $reservation->reservation_date = $request->reservation_date;
        $reservation->total_price = $program->total_price;  // Utiliser le prix du programme
        $reservation->save();

        // Retourner à la liste des réservations avec un message de succès
        return redirect()->route('invoice.index')->with('success', 'Réservation ajoutée avec succès!');
    }

    /**
     * Display the specified reservation.
     */
    public function show($id)
    {
        // Trouver la réservation
    }

    /**
     * Show the form for editing the specified reservation.
     */
    public function edit($id)
    {
        // Récupérer la réservation, programmes et clients

    }

    /**
     * Update the specified reservation in storage.
     */
    public function update(Request $request, $id)
    {
        // Validation des données
        $request->validate([
            'client_id' => 'required|exists:clients,idClient',
            'program_id' => 'required|exists:programs,id',
            'reservation_date' => 'required|date',
        ]);

        // Mettre à jour la réservation
        $reservation = Reservation::findOrFail($id);
        $reservation->client_id = $request->client_id;
        $reservation->program_id = $request->program_id;
        $reservation->reservation_date = $request->reservation_date;
        $reservation->total_price = $request->total_price;
        $reservation->save();
        return redirect()->route('reservation.index')->with('success', 'Réservation mise à jour avec succès!');
    }
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return redirect()->route('reservation.index')->with('success', 'Réservation supprimée avec succès!');
    }

}
