<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vuelo extends Model
{
    use HasFactory;

    protected $table = 'vuelo';
    protected $primaryKey = 'IDVuelo';
    public $timestamps = false;
    protected $fillable = [
        'fechaHraSalida', 'fechaHraLlegada', 'origen', 'destino', 
        'plazasTotales', 'plazasPrimeraClase', 'plazasEjecutiva', 'plazasEconomica', 
        'plazasDisponiblesPrimeraClase', 'plazasDisponiblesEjecutiva', 'plazasDisponiblesEconomica', 'estado', 	
        'plazasDisponiblesTotales'
    ];
    
    public function claseVuelo()
    {
        return $this->belongsTo(ClaseVuelo::class, 'IDClaseVuelo');
    }

    //mutar los datos por la fn strtoupper
    public function setOrigenAttribute($value)
    {
        $this->attributes['origen'] = mb_strtoupper($value, 'UTF-8');
    }

    // Mutador para el campo 'ciudad'
    public function setDestinoAttribute($value)
    {
        $this->attributes['destino'] = mb_strtoupper($value, 'UTF-8');
    }

}

