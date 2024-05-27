<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaseVuelo extends Model
{
    use HasFactory;

    protected $table = 'clasevuelo';
    protected $primaryKey = 'IDClaseVuelo';
    public $timestamps = false;
    protected $fillable = ['descripcionClase', 'estado'];
   
}
