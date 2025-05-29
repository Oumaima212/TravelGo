<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $primaryKey = 'idClient'; // Définit 'idClient' comme clé primaire
    public $incrementing = true; // Clé primaire auto-incrémentée
    protected $keyType = 'int'; // Type de la clé primaire

    protected $fillable = [
        'idClient',
        'last_name',
        'first_name',
        'last_name_arabic',
        'first_name_arabic',
        'gender',
        'date_of_birth',
        'country',
        'passport_number',
        'phone',
        'affiliate',
        'email',
        'address',
        'notes',
        'id_company',
        'cin',
    ];

    public function company()
{
    return $this->belongsTo(Company::class, 'idCompany');
}

}
