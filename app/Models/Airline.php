<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    use HasFactory;

    // Nom de la table si différent de la convention Laravel ('airlines' dans ce cas)
    protected $table = 'airlines';

    // Les champs qui peuvent être assignés en masse
    protected $fillable = [
        'name',          // Nom de la compagnie aérienne
        'code',         // Code unique de la compagnie
        'statut',       // Statut de la compagnie (actif/inactif)
        'logo',         // Lien vers le logo (optionnel)
    ];

    // Optionnel : les champs castés pour certains types
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
