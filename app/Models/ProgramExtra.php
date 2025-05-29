<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramExtra extends Model
{
    use HasFactory;

    // Indiquer le nom de la table pivot si nécessaire
    protected $table = 'program_extra';

    // Indiquer les colonnes pouvant être massivement assignées
    protected $fillable = ['program_id', 'extra_id', 'extra_details_id', 'extra_sale_price'];

    // Les relations (si tu souhaites accéder aux données des autres modèles)
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function extra()
    {
        return $this->belongsTo(Extra::class);
    }

    public function extraDetail()
    {
        return $this->belongsTo(ExtraDetail::class, 'extra_details_id');
    }
}
