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
        Schema::table('movimenti_magazzino', function (Blueprint $table) {
            $table->foreignId('utente_id')->nullable()->constrained('users')->onDelete('set null');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movimenti_magazzino', function (Blueprint $table) {
            //
        });
    }
};
