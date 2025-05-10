<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffertaTgtg extends Model
{
    use HasFactory;

    protected $table = 'offerte_tgtg';

    protected $fillable = [
        'prodotto_id',
        'quantità',
        'prezzo_scontato',
        'disponibile_fino',
        'prenotata',
    ];

    // Ogni offerta TGTG è legata a un prodotto
    public function prodotto()
    {
        return $this->belongsTo(Prodotto::class);
    }
}
