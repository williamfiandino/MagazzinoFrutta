<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRolesInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Modifica del campo 'ruolo'
            // Se il campo è un ENUM, devi aggiornarlo per riflettere i nuovi ruoli
            $table->enum('ruolo', ['amministratore', 'venditore', 'cliente'])->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Ritorna i vecchi valori del campo 'ruolo'
            $table->enum('ruolo', ['amministratore', 'operatore', 'visualizzatore'])->change();
        });
    }
}
