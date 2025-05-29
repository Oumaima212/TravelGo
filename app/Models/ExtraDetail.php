<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraDetail extends Model
{
    use HasFactory;

    protected $table = 'extra_details';

    protected $fillable = ['idExtra', 'extraCompanyName', 'extraPurchasePrice', 'extraSalePrice'];

    public function extra()
    {
        return $this->belongsTo(Extra::class, 'idExtra');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
