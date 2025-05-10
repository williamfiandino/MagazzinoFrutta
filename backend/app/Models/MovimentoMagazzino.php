<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentoMagazzino extends Model
{
    use HasFactory;

    protected $table = 'movimenti_magazzino';

    protected $fillable = [
        'prodotto_id',
        'fornitore_id',
        'cliente_id',
        'tipo',
        'quantità',
        'prezzo_unitario',
        'data',
        'causale',
        'lotto',
    ];

    // Relazione con Prodotto
    public function prodotto()
    {
        return $this->belongsTo(Prodotto::class);
    }

    // Relazione con Fornitore (opzionale)
    public function fornitore()
    {
        return $this->belongsTo(Fornitore::class);
    }

    // Relazione con Cliente (opzionale)
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function utente()
    {
        return $this->belongsTo(User::class, 'utente_id');
    }
}
