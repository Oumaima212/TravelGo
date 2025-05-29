<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Program extends Model
{
    use HasFactory;

    protected $table = 'programs';

    protected $fillable = [
        'name', 'prestataire_id', 'country_id', 'description', 'start_date', 'end_date',
        'profit', 'total_price'
    ];

    /**
     * Relation avec les services associés au programme.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Relation avec les commissions associées au programme.
     */
    public function commissions()
    {
        return $this->hasMany(Commission::class, 'idProgram');
    }

    /**
     * Relation avec le prestataire du programme.
     */
    public function prestataire()
    {
        return $this->belongsTo(User::class, 'prestataire_id');
    }

    /**
     * Relation avec le pays du programme.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * Relation avec les extras associés au programme (via une table pivot).
     */
    public function extras()
    {
        return $this->belongsToMany(Extra::class, 'program_extra')
                    ->withPivot('extra_details_id', 'extra_sale_price')
                    ->withTimestamps();
    }



    /**
     * Calcul du prix total du programme (y compris extras et profit).
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($program) {
            $totalExtras = $program->extras->sum(function ($extra) {
                return $extra->pivot->extra_sale_price ?? 0;
            });
            $program->total_price = $totalExtras + ($program->profit ?? 0);
        });
    }
    public function calculateTotalPrice()
    {
        // Calculer la somme des prix des extras
        $totalExtras = $this->extras->sum(function ($extra) {
            return $extra->pivot->extra_sale_price ?? 0; // Défaut à 0 si non défini
        });

        // Récupérer le profit
        $totalProfit = $this->profit ?? 0;

        // Calcul du total
        $totalPrice = $totalExtras + $totalProfit;
// dd($totalPrice , $totalExtras , $totalProfit);
        // Débogage
        \Log::info("Extras Total: $totalExtras, Profit: $totalProfit, Total Price: $totalPrice");

        // Mettre à jour la base de données
        $this->total_price = $totalPrice;
        $this->save();
    }

}
