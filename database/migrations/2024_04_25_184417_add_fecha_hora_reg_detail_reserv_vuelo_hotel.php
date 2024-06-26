<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('detail_reserv_vuelo_hotel', function (Blueprint $table) {
            $table->dateTime('fechaHoraRegimen')->nullable();
            $table->dateTime('fechaHoraRegFin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_reserv_vuelo_hotel', function (Blueprint $table) {
            $table->dropColumn(['fechaHoraRegimen', 'fechaHoraRegFin']);
        });
    }

};
