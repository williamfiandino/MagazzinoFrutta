<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'ruolo', // può essere 'amministratore', 'venditore', 'cliente'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function prodotti()
    {
        return $this->hasMany(Prodotto::class, 'utente_id');
    }

    public function èAmministratore()
    {
        return $this->ruolo === 'amministratore';
    }

    public function èVenditore()
    {
        return $this->ruolo === 'venditore';
    }

    public function èCliente()
    {
        return $this->ruolo === 'cliente';
    }

    public function hasRole($role)
    {
        return $this->ruolo === $role;
    }
}
