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
        Schema::create('movimenti_magazzino', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prodotto_id')->constrained('prodotti')->onDelete('cascade');
            $table->foreignId('fornitore_id')->nullable()->constrained('fornitori')->onDelete('set null');
            $table->foreignId('cliente_id')->nullable()->constrained('clienti')->onDelete('set null');
            $table->enum('tipo', ['entrata', 'uscita']);
            $table->integer('quantità');
            $table->decimal('prezzo_unitario', 8, 2)->nullable();
            $table->date('data');
            $table->string('causale')->nullable();
            $table->string('lotto')->nullable();
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
        Schema::dropIfExists('movimento_magazzinos');
    }
};
