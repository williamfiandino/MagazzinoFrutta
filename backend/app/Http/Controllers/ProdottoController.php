<?php
/*
namespace App\Http\Controllers;

use App\Models\Prodotto;
use Illuminate\Http\Request;

class ProdottoController extends Controller
{
    // Lista tutti i prodotti
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user?->èVenditore()) {
            // Il venditore vede solo i suoi prodotti
            $prodotti = Prodotto::where('utente_id', $user->id)->get();
        } else {
            // Cliente o utente non autenticato vede tutti i prodotti
            $prodotti = Prodotto::all();
        }

        return response()->json($prodotti, 200);
    }

    // Crea nuovo prodotto
    

    // Visualizza un singolo prodotto
    public function show($id)
    {
        $prodotto = Prodotto::findOrFail($id);
        return response()->json($prodotto);
    }

    // Aggiorna un prodotto
    

    // Elimina un prodotto
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $prodotto = Prodotto::findOrFail($id);

        if ($user->id !== $prodotto->utente_id && !$user->èAmministratore()) {
            return response()->json(['message' => 'Non autorizzato'], 403);
        }

        $prodotto->delete();

        return response()->json(null, 204);
    }

    // Prodotti in esaurimento
    public function prodottiEsauriti(Request $request)
    {
        $user = $request->user();

        if ($user?->èVenditore()) {
            $prodotti = Prodotto::where('utente_id', $user->id)
                ->whereColumn('quantità_magazzino', '<=', 'soglia_scorta')
                ->get();
        } else {
            $prodotti = Prodotto::whereColumn('quantità_magazzino', '<=', 'soglia_scorta')->get();
        }

        return response()->json($prodotti);
    }
}*/

namespace App\Http\Controllers;

use App\Models\Prodotto;
use Illuminate\Http\Request;

class ProdottoController extends Controller
{
    public function index(Request $request)
    {
        $query = Prodotto::query();

        // Filtro per nome
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        // Filtro per varietà
        if ($request->filled('varieta')) {
            $query->where('varietà', 'like', '%' . $request->varieta . '%');
        }

        // Filtro per prezzo massimo
        if ($request->filled('prezzoMax')) {
            $query->where('prezzo_unitario', '<=', $request->prezzoMax);
        }

        // Filtro per quantità minima
        if ($request->filled('quantitaMin')) {
            $query->where('quantità_magazzino', '>=', $request->quantitaMin);
        }

        // Se l’utente è un venditore, restituisce solo i suoi prodotti
        $user = $request->user();
        if ($user?->èVenditore()) {
            $query->where('utente_id', $user->id);
        }

        $prodotti = $query->orderBy('nome')->get();

        return response()->json($prodotti);
    }


    // Aggiungi un nuovo prodotto (solo per venditori)
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->èVenditore() && !$user->èAmministratore()) {
            return response()->json(['message' => 'Non autorizzato'], 403);
        }

        $request->validate([
            'nome' => 'required|string',
            'prezzo_unitario' => 'required|numeric',
            'quantità_magazzino' => 'nullable|integer',
            'soglia_scorta' => 'nullable|integer',
        ]);

        $prodotto = new Prodotto($request->all());
        $prodotto->utente_id = $user->id;
        $prodotto->save();

        return response()->json($prodotto, 201);
    }

    // Modifica un prodotto (solo per venditori)
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $prodotto = Prodotto::findOrFail($id);

        if ($user->id !== $prodotto->utente_id && !$user->èAmministratore()) {
            return response()->json(['message' => 'Non autorizzato'], 403);
        }

        $request->validate([
            'nome' => 'sometimes|string',
            'prezzo_unitario' => 'sometimes|numeric',
            'quantità_magazzino' => 'sometimes|integer',
            'soglia_scorta' => 'sometimes|integer',
        ]);

        $prodotto->update($request->all());

        return response()->json($prodotto);
    }

    // Elimina un prodotto (solo per venditori)
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $prodotto = Prodotto::findOrFail($id);

        if ($user->id !== $prodotto->utente_id && !$user->èAmministratore()) {
            return response()->json(['message' => 'Non autorizzato'], 403);
        }

        $prodotto->delete();

        return response()->json(null, 204);
    }

    public function prodottiEsauriti(Request $request)
    {
        $user = $request->user();

        if ($user?->èVenditore()) {
            $prodotti = Prodotto::where('utente_id', $user->id)
                ->whereColumn('quantità_magazzino', '<=', 'soglia_scorta')
                ->get();
        } else {
            $prodotti = Prodotto::whereColumn('quantità_magazzino', '<=', 'soglia_scorta')->get();
        }

        return response()->json($prodotti);
    }
}
