<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotel';
    protected $primaryKey = 'IDHotel';
    public $timestamps = false;
    protected $fillable = ['nombre', 'numEstrellas', 'estado', 'ciudad', 'telefono', 'totalRooms', 'singleRooms', 'doubleRooms', 'familyRooms','habitacionesDisponiblesSingle',
    'habitacionesDisponiblesDouble',
    'habitacionesDisponiblesFamily',
    'habitacionesDisponiblesTotales'];

    public function regimenHospedaje()
{
    return $this->belongsTo(Regimen_hospedaje::class, 'IDRegimenHospedaje');
}

public function setNombreAttribute($value)
{
    $this->attributes['nombre'] = mb_strtoupper($value, 'UTF-8');
}

public function setCiudadAttribute($value)
{
    $this->attributes['ciudad'] = mb_strtoupper($value, 'UTF-8');
}

// Relación con la tabla 'detail_reserv_vuelo_hotel'
public function detailReservVueloHotel()
{
    return $this->hasMany(DetailReservVueloHotel::class, 'IDHotel', 'IDHotel');
}

}
