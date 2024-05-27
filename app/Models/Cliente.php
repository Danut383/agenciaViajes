<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';
    protected $primaryKey = 'NIFCliente';
    public $timestamps = false;
    protected $fillable = ['nombre', 'ciudad', 'telefono', 'email', 'estado'];

    // Relación con Reservaciones
    public function reservaciones()
    {
        return $this->hasMany(Reservacion::class, 'NIFCliente', 'NIFCliente');
    }

    //mutar los datos por la fn strtoupper
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = mb_strtoupper($value, 'UTF-8');       ///Permitir carácteres de multiple byte
    }
    
    // Mutador para el campo 'ciudad'
    public function setCiudadAttribute($value)
    {
        $this->attributes['ciudad'] = mb_strtoupper($value, 'UTF-8');
    }
    
}
