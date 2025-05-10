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
        Schema::create('offerte_tgtg', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prodotto_id')->constrained('prodotti')->onDelete('cascade');
            $table->integer('quantità');
            $table->decimal('prezzo_scontato', 8, 2);
            $table->date('disponibile_fino');
            $table->boolean('prenotata')->default(false);
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
        Schema::dropIfExists('offerta_tgtgs');
    }
};
