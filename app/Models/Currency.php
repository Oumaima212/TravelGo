<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currencies';
    protected $primaryKey = 'idCurrency';

    protected $fillable = [
        'currencyName',
        'exchangeRate',
        'isDefault',
        'idCountry',
    ];

    // Relation avec Country
    public function country()
    {
        return $this->belongsTo(Country::class, 'idCountry');
    }
}
