<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservacion extends Model
{
    use HasFactory;

    protected $table = 'reservacion';
    protected $primaryKey = 'IDReservacion';
    public $timestamps = false;
    protected $fillable = ['IDSucursal', 'NIFCliente', 'fechaReservacion', 'estado', 'IDVuelo', 'IDHotel'];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'NIFCliente');
    }

    // Relación con Sucursal
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'IDSucursal');
    }

    // Relación con Vuelo
    public function vuelo()
    {
        return $this->belongsTo(Vuelo::class, 'IDVuelo')->withDefault([
            'destino' => 'NO APLICA' // Retorna un objeto predeterminado si no hay vuelo asociado
        ]);
    }

    // Relación con Hotel
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'IDHotel')->withDefault([
            'nombre' => 'NO APLICA' // Retorna un objeto predeterminado si no hay hotel asociado
        ]);
    }
  
    // Relación con Detail_reserv_vuelo_hotel
   
    public function detailReservVueloHotel()
    {
        return $this->hasOne(DetailReservVueloHotel::class, 'IDReservacion', 'IDReservacion');
    }

}