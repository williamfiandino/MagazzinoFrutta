<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prodotti', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('varietà')->nullable();
            $table->text('descrizione')->nullable();
            $table->string('unità_misura')->default('kg');
            $table->decimal('prezzo_unitario', 8, 2);
            $table->integer('quantità_magazzino')->default(0);
            $table->integer('soglia_scorta')->default(10);
            $table->string('immagine')->nullable();
            $table->date('data_scadenza')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prodottos');
    }
};
