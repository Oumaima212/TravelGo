<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log; // Ajoutez cette ligne

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        // Log des données reçues pour le débogage
        Log::info($this->all()); // Utilisez Log ici

        return [
            'nom' => 'required|string|max:255',
            'telephone' => 'required|string|max:15', // Ajustez selon votre besoin
            'email' => 'required|email|unique:users,email,' . $this->user()->id, // Vérifie l'unicité de l'email, excepté pour l'utilisateur actuel
            'motdepasse' => 'nullable|string|min:8|confirmed', // Assurez-vous que le mot de passe est confirmé
        ];
    }

    public function authorize(): bool
    {
        return true; // Autorise toutes les requêtes par défaut
    }
}
