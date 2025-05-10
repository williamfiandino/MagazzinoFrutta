<?php

/*

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


use App\Http\Controllers\ProdottoController;
use App\Http\Controllers\MovimentoMagazzinoController;
use App\Http\Controllers\FornitoreController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\OffertaTgtgController;
use App\Http\Controllers\DashboardController;

// Login - genera token Sanctum (senza usare Auth::attempt())
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenziali non valide'], 401);
    }

    return response()->json([
        'token' => $user->createToken('magazzino')->plainTextToken
    ]);
});

// Registrazione dell'utente
Route::post('/register', function (Request $request) {
    // STAMPIAMO IL CONTENUTO DELLA REQUEST (per il debug)
    logger('DEBUG REGISTER', [
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
        'password_confirmation' => $request->password_confirmation,
        'ruolo' => $request->ruolo,  // Verifica se il campo "ruolo" viene passato
    ]);

    // Valida la richiesta
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'ruolo' => 'required|in:amministratore,venditore,cliente', // Validazione per il campo ruolo
    ]);

    // Crea il nuovo utente
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Cripta la password
        'ruolo' => $request->ruolo, // Assegna il ruolo
    ]);

    // Restituisce la risposta con il messaggio di successo e il token
    return response()->json([
        'message' => 'Utente creato con successo',
        'token' => $user->createToken('token-magazzino')->plainTextToken
    ], 201);
});

/* inizio commento
// Rotte pubbliche
Route::get('/prodotti', [ProdottoController::class, 'index']);

Route::middleware(['auth:sanctum', 'venditore'])->group(function () {
    // solo venditori
    Route::post('/prodotti', [ProdottoController::class, 'store']);
    Route::put('/prodotti/{id}', [ProdottoController::class, 'update']);
    Route::delete('/prodotti/{id}', [ProdottoController::class, 'destroy']);
});

// Rotte protette da autenticazione Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('fornitori', FornitoreController::class);
    Route::apiResource('clienti', ClienteController::class);
    Route::apiResource('movimenti', MovimentoMagazzinoController::class);
    Route::apiResource('offerte-tgtg', OffertaTgtgController::class);

    Route::get('prodotti-esauriti', [ProdottoController::class, 'prodottiEsauriti']);
    Route::get('dashboard', [DashboardController::class, 'statistiche']);
});
//fine commento

Route::get('/prodotti', [ProdottoController::class, 'index']); // pubblico


Route::middleware(['auth:sanctum', 'role:venditore'])->get('/test-venditore', function () {
    return response()->json(['ok' => true]);
});



Route::middleware(['auth:sanctum'])->group(function () {
    // accesso solo a utenti autenticati
    Route::get('/profilo', function () {
        return auth()->user();
    });

    // accesso solo a venditori
    Route::middleware('role:venditore')->group(function () {
        Route::post('/prodotti', [ProdottoController::class, 'store']);
        Route::put('/prodotti/{id}', [ProdottoController::class, 'update']);
        Route::delete('/prodotti/{id}', [ProdottoController::class, 'destroy']);
    });
});*/


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use App\Http\Controllers\ProdottoController;
use App\Http\Controllers\MovimentoMagazzinoController;
use App\Http\Controllers\FornitoreController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\OffertaTgtgController;
use App\Http\Controllers\DashboardController;

// Login
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenziali non valide'], 401);
    }

    return response()->json([
        'token' => $user->createToken('magazzino')->plainTextToken
    ]);
});

// Registrazione
Route::post('/register', function (Request $request) {
    logger('DEBUG REGISTER', [
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
        'password_confirmation' => $request->password_confirmation,
        'ruolo' => $request->ruolo,
    ]);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'ruolo' => 'required|in:amministratore,venditore,cliente',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'ruolo' => $request->ruolo,
    ]);

    return response()->json([
        'message' => 'Utente creato con successo',
        'token' => $user->createToken('token-magazzino')->plainTextToken
    ], 201);
});

// Rotte pubbliche
Route::get('/prodotti', [ProdottoController::class, 'index']); // accesso libero

// Test venditore (per debugging)
Route::middleware(['auth:sanctum', 'role:venditore'])->get('/test-venditore', function () {
    return response()->json(['ok' => true]);
});

// Rotte protette da autenticazione
Route::middleware(['auth:sanctum'])->group(function () {
    // Profilo utente autenticato
    Route::get('/profilo', function () {
        return auth()->user();
    });

    // Rotte per venditori
    Route::middleware('role:venditore')->group(function () {
        Route::post('/prodotti', [ProdottoController::class, 'store']);
        Route::put('/prodotti/{id}', [ProdottoController::class, 'update']);
        Route::delete('/prodotti/{id}', [ProdottoController::class, 'destroy']);
    });

    // Rotta accessibile a venditori **e** amministratori
    Route::get('/prodotti-esauriti', [ProdottoController::class, 'prodottiEsauriti']);

    // (Aggiungile in seguito) Rotte per dashboard, fornitori, clienti, movimenti, tgtg ecc.
});
