<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Providers\RouteServiceProvider;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users'; // Nom de la table

    protected $fillable = [
        'name',
        'role', // Role unique entry
        'phone',
        'email',
        'status',
        'dateJoined',
        'idCompany',
        'password',
    ];

    // Define relationships here if necessary
    public function company()
    {
        return $this->belongsTo(Company::class, 'idCompany', 'idCompany');
    }

    // Specify the authentication identifier
    public function getAuthIdentifierName()
    {
        return 'email'; // Or 'idUser' depending on your authentication field
    }

    public function getAuthIdentifier()
    {
        return $this->getAttribute($this->getAuthIdentifierName());
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function hasRole(string $role): bool
    {
        return $this->getAttribute('role') === $role;
    }

    public function getRedirectRoute()
    {
        if ($this->isUser()) {
            return 'user_dashboard';
        } elseif ($this->isAdmin()) {
            return 'admin_dashboard';
        }
        return RouteServiceProvider::HOME;
    }
}
