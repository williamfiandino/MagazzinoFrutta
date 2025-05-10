<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clienti';

    protected $fillable = [
        'nome',
        'email',
        'telefono',
        'indirizzo',
    ];

    // Un cliente può avere molti movimenti di uscita
    public function movimenti()
    {
        return $this->hasMany(MovimentoMagazzino::class);
    }
}
