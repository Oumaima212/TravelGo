<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $table = 'commissions';

    protected $fillable = [
        'name',
        'status',
    ];

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class);
    }


    }

