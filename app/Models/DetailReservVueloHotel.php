<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReservVueloHotel extends Model
{
    use HasFactory;

    protected $table = 'detail_reserv_vuelo_hotel';
    protected $primaryKey = 'IDDetalleReservarVueloH';
    public $timestamps = false;
    protected $fillable = [
        'IDVuelo', 'IDClaseVuelo', 'IDHotel', 'IDReservacion', 'IDRegimenHospedaje', 
        'fechahoraLlegada', 'fechahoraSalida', 'estado', 'fechaHoraRegimen', 
        'fechaHoraRegFin', 'tipoHabitacion', 'numeroPersonas', 'boletos'
    ];

    // Relación con la tabla 'vuelo'
    public function vuelo()
    {
        return $this->belongsTo(Vuelo::class, 'IDVuelo', 'IDVuelo');
    }

    // Relación con la tabla 'clasevuelo'
    public function claseVuelo()
    {
        return $this->belongsTo(ClaseVuelo::class, 'IDClaseVuelo', 'IDClaseVuelo');
    }

    // Relación con la tabla 'hotel'
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'IDHotel', 'IDHotel');
    }

    // Relación con la tabla 'regimen_hospedaje'
    public function regimenHospedaje()
    {
        return $this->belongsTo(RegimenHospedaje::class, 'IDRegimenHospedaje', 'IDRegimenH');
    }

    // Relación con la tabla 'reservacion'
    public function reservacion()
    {
        return $this->belongsTo(Reservacion::class, 'IDReservacion', 'IDReservacion');
    }
}