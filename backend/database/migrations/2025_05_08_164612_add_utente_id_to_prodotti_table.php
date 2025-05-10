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
        Schema::table('prodotti', function (Blueprint $table) {
            $table->foreignId('utente_id')->constrained('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('prodotti', function (Blueprint $table) {
            $table->dropForeign(['utente_id']);
            $table->dropColumn('utente_id');
        });
    }
};
