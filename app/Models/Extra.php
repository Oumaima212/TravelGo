<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ExtraDetail;

class Extra extends Model
{
    use HasFactory;

    protected $table = 'extras';

    protected $fillable = [
        'type',
    ];

    // Relation avec les détails de l'extra
    public function details()
    {
        return $this->hasMany(ExtraDetail::class, 'idExtra', 'id');
    }

    // Relation many-to-many avec le programme via la table pivot
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'program_extra')
                    ->withPivot('extra_details_id', 'extra_sale_price')
                    ->withTimestamps();
    }

}
