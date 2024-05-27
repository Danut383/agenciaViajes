<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
    {
        Schema::table('vuelo', function (Blueprint $table) {
            $table->integer('plazasPrimeraClase')->default(0);
            $table->integer('plazasEjecutiva')->default(0);
            $table->integer('plazasEconomica')->default(0);
            $table->integer('plazasDisponiblesPrimeraClase')->default(0);
            $table->integer('plazasDisponiblesEjecutiva')->default(0);
            $table->integer('plazasDisponiblesEconomica')->default(0);
        });
    }

    public function down()
    {
        Schema::table('vuelo', function (Blueprint $table) {
            $table->dropColumn(['plazasPrimeraClase', 'plazasEjecutiva', 'plazasEconomica', 'plazasDisponiblesPrimeraClase', 'plazasDisponiblesEjecutiva', 'plazasDisponiblesEconomica']);
        });
    }

};
