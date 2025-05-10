<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornitore extends Model
{
    use HasFactory;

    protected $table = 'fornitori';

    protected $fillable = [
        'nome',
        'email',
        'telefono',
        'indirizzo',
    ];

    // Un fornitore può avere molti movimenti di magazzino
    public function movimenti()
    {
        return $this->hasMany(MovimentoMagazzino::class);
    }
}
