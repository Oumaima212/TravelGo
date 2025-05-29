<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'program_id',
        'reservation_date',
        'total_price',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'idClient');
    }

    // Créer une facture automatiquement lors de la création de la réservation
    protected static function booted()
    {
        static::created(function ($reservation) {
            // Créer une facture automatiquement après la réservation
            Invoice::create([
                'invoiceReference' => 'INV-' . time(), // Référence unique générée par timestamp
                'invoiceDate' => now(), // Date de la facture
                'status' => 'Pending', // Statut par défaut de la facture
                'totalAmount' => $reservation->total_price, // Montant total basé sur la réservation
                'amountDue' => $reservation->total_price, // Montant dû par le client
                'discount' => 0, // Pas de remise par défaut
                'client_id' => $reservation->client_id, // ID du client
                'program_id' => $reservation->program_id, // ID du programme réservé
            ]);
        });
    }
    // Dans le modèle Reservation
public function invoice()
{
    return $this->hasOne(Invoice::class);
}

}
