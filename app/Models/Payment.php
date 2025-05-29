<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments'; // Spécifie le nom de la table

    protected $fillable = [
        'amount',
        'date',
        'method',
        'transactionNumber',
        'status',
        'idClient',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class, 'idClient', 'idClient');
    }


    

}
