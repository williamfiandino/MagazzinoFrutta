<?php

namespace App\Http\Controllers;

use App\Models\MovimentoMagazzino;
use App\Models\Prodotto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovimentoMagazzinoController extends Controller
{
    public function index()
    {
        return MovimentoMagazzino::with(['prodotto', 'fornitore', 'cliente'])->orderBy('data', 'desc')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:entrata,uscita',
            'prodotto_id' => 'required|exists:prodotti,id',
            'quantità' => 'required|numeric|min:0.01',
            'data' => 'required|date',
        ]);

        $dati = $request->all();
        $dati['utente_id'] = Auth::id();

        $movimento = MovimentoMagazzino::create($dati);

        // Aggiornamento stock
        $prodotto = Prodotto::find($request->prodotto_id);

        if ($request->tipo === 'entrata') {
            $prodotto->quantità_magazzino += $request->quantità;
        } else {
            if ($prodotto->quantità_magazzino < $request->quantità) {
                return response()->json(['errore' => 'Stock insufficiente per uscita'], 400);
            }
            $prodotto->quantità_magazzino -= $request->quantità;
        }

        $prodotto->save();

        return response()->json($movimento->load(['prodotto', 'utente']), 201);
    }

    public function show($id)
    {
        return MovimentoMagazzino::with(['prodotto', 'fornitore', 'cliente'])->findOrFail($id);
    }

    public function destroy($id)
    {
        // ⚠️ Elimina solo il movimento, NON ripristina lo stock
        $movimento = MovimentoMagazzino::findOrFail($id);
        $movimento->delete();

        return response()->json(null, 204);
    }
}
