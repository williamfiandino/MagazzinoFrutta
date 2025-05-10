<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodotto extends Model
{
    use HasFactory;

    protected $table = 'prodotti';

    protected $fillable = [
        'nome',
        'varietà',
        'descrizione',
        'unità_misura',
        'prezzo_unitario',
        'quantità_magazzino',
        'soglia_scorta',
        'immagine',
        'data_scadenza',
        'utente_id',
    ];

    // Un prodotto può avere molti movimenti di magazzino
    public function movimenti()
    {
        return $this->hasMany(MovimentoMagazzino::class);
    }

    // Un prodotto può avere molte offerte TooGoodToGo
    public function offerteTgtg()
    {
        return $this->hasMany(OffertaTgtg::class);
    }

    public function utente()
    {
        return $this->belongsTo(User::class);
    }
}
