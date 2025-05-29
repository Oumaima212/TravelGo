<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $table = 'accommodations';
    protected $primaryKey = 'idAccommodation';

    protected $fillable = [
        'prestataire_id',
        'commission_id',
        'role',
        'phone',
        'name',
        'email',
        'status',
        'dateJoined',
        'address',
        'distance',
        'type',
    ];

    public function prestataire()
    {
        return $this->belongsTo(User::class, 'prestataire_id');
    }


    public function commission()
    {
        return $this->belongsTo(Commission::class, 'commission_id');
    }



}
