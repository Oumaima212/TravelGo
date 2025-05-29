<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; // Importation de la façade Auth pour gérer l'authentification
use App\Models\User; // Importation du modèle User
use App\Models\Invitation; // Importation du modèle Invitation
use App\Mail\InvitationEmail; // Importation de la classe d'email InvitationEmail
use Illuminate\Support\Str; // Importation de la façade Str pour générer des chaînes aléatoires
use Illuminate\Http\Request; // Importation de la classe Request pour gérer les requêtes HTTP
use Illuminate\Support\Facades\Mail; // Importation de la façade Mail pour envoyer des emails

class InvitationController extends Controller
{
    public function index(Request $request)
    {
        // Récupération du terme de recherche
        $search = $request->input('search');

        // Vérification de la présence du terme de recherche pour filtrer les invitations
        if ($search) {
            // Filtrer les invitations en fonction de l'email
            $invitations = Invitation::where('email', 'like', '%' . $search . '%')->paginate(10);
        } else {
            // Récupérer toutes les invitations sans filtre
            $invitations = Invitation::paginate(10);
        }

        // Retourner la vue avec les invitations et le terme de recherche
        return view('contents.invitation', compact('invitations', 'search'));
    }


    // Méthode pour inviter un utilisateur
    public function invite(Request $request)
    {
        // Validation de la requête pour s'assurer que l'email est fourni et qu'il est au format valide
        $request->validate(['email' => 'required|email']);

        // Recherche l'utilisateur par son email
        $user = User::where('email', $request->email)->first();

        // Si l'utilisateur n'existe pas, redirige avec un message d'erreur
        if (!$user) {
            return redirect()->route('invite.form')->with('error', 'Utilisateur non trouvé');
        }

        // Création d'une nouvelle invitation avec les détails fournis
        $invitation = Invitation::create([
            'email' => $request->email,
            'invitationDate' => now(), // Date actuelle
            'status' => 'pending', // Statut de l'invitation
            'idUser' => $user->id, // ID de l'utilisateur qui envoie l'invitation
            'token' => Str::random(32), // Génération d'un token aléatoire pour l'invitation
        ]);

        // Envoi de l'email d'invitation à l'utilisateur
        Mail::to($request->email)->send(new InvitationEmail($invitation));

        // Redirige vers le formulaire d'invitation avec un message de succès
        return redirect()->route('invite.form')->with('success', 'Invitation envoyée avec succès');
    }

    // Méthode pour accepter une invitation
    public function accept($token)
    {
        // Recherche l'invitation par le token
        $invitation = Invitation::where('token', $token)->first();

        /*
        // Commenté: Vérification de l'invitation
        if (!$invitation) {
            return redirect('/')->with('error', 'Invitation invalide.');
        }

        // Commenté: Vérification si l'invitation a déjà été acceptée
        if ($invitation->status === 'accepted') {
            return redirect('/')->with('error', 'Cette invitation a déjà été acceptée.');
        }
        */

        // Recherche l'utilisateur par son email
        $user = User::where('email', $invitation->email)->first();

        // Si l'utilisateur n'existe pas, crée un nouvel utilisateur
        if (!$user) {
            $user = User::create([
                'email' => $invitation->email,
                'name' => 'Nom par défaut', // Nom par défaut pour l'utilisateur
                'password' => bcrypt($invitation->password), // Hachage du mot de passe
            ]);
        } else {
            // Si l'utilisateur existe, rien à faire (peut-être ajouter un message ici si nécessaire)
        }

        // Authentifie l'utilisateur
        Auth::login($user);

        // Met à jour le statut de l'invitation à 'accepted'
        $invitation->status = 'accepted';
        $invitation->save();

        // Redirige vers le tableau de bord de l'utilisateur
        return redirect()->route('user_dashboard');
    }
}
