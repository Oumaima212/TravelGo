<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'prestataire_id',
        'name',
        'type',
        'price',
    ];

    public function prestataire()
    {
        return $this->belongsTo(User::class, 'prestataire_id');
    }


}
