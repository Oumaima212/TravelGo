<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'idRole';

    protected $fillable = [
        'name',
        'description',
    ];
    public function users()
{
    return $this->hasMany(User::class, 'idRole');
}

}
