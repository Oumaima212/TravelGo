<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $table = 'invitations';
    protected $primaryKey = 'idInvitation';

    protected $fillable = [
        'email',
        'invitationDate',
        'status',
        'idUser',
        'token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }
}
