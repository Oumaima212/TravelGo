<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'charges';

    /**
     * Les attributs pouvant être attribués en masse.
     *
     * @var array
     */
    protected $fillable = [
        'nom',           // Nom de la charge
        'type_charge',   // Type de charge (salaire, entretien, etc.)
        'montant',       // Montant de la charge
        'date_charge',   // Date de la charge
        'description',   // Description optionnelle
    ];

    /**
     * Les attributs devant être convertis en types natifs.
     *
     * @var array
     */
    protected $casts = [
        'date_charge' => 'date',
        'montant' => 'float',
    ];
}
