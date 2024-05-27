<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursal';
    protected $primaryKey = 'IDSucursal';
    public $timestamps = false;
    protected $fillable = ['codigoSucursal', 'direccion', 'ciudad', 'provincia', 'nombreSucursal', 'estado', 'noExt' ];

    //mutar los datos por la fn mb_strtupper, para permitir multiple byte en cáracter
    public function setDireccionAttribute($value)
    {
        $this->attributes['direccion'] = mb_strtoupper($value, 'UTF-8');
    }
    
    // Mutador para el campo 'ciudad'
    public function setCiudadAttribute($value)
    {
        $this->attributes['ciudad'] = mb_strtoupper($value, 'UTF-8');
    }
    
    // Mutador para el campo 'provincia'
    public function setProvinciaAttribute($value)
    {
        $this->attributes['provincia'] = mb_strtoupper($value, 'UTF-8');
    }
    
    // Mutador para el campo 'nombre de sucursal'
    public function setNombreSucursalAttribute($value)
    {
        $this->attributes['nombreSucursal'] = mb_strtoupper($value, 'UTF-8');
    }
    
    public function reservaciones()
    {
        return $this->hasMany(Reservacion::class, 'IDSucursal');
    }
}
