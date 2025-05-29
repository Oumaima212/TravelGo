<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller
{
    // Afficher les informations du profil utilisateur
    public function edit(Request $request): View
    {
        // Récupérer l'utilisateur authentifié
        $user = $request->user();
        $isUpdate = false;
        return view('contents.account', compact('user', 'isUpdate'));
    }

    // Mettre à jour les informations du profil
    public function update(Request $request, $id)
    {
        User::findOrFail($id);

        // Validation des données
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email',
            'motdepasse' => 'nullable|string|min:8|confirmed',
        ]);

        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Mettre à jour les informations

        $user->name = $validatedData['nom'];
        $user->phone = $validatedData['telephone'];
        $user->emailt = $validatedData['email'];

        // Mettre à jour le mot de passe si rempli
        if ($request->filled('motdepasse')) {
            $user->password = Hash::make($request->motdepasse);
        }

        // Sauvegarder les modifications
        $user->save();

        return Redirect::route('user.edit')->with('status', 'profile-updated');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
