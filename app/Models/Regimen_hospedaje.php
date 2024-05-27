<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regimen_hospedaje extends Model
{
    use HasFactory;

    protected $table = 'regimen_hospedaje';
    protected $primaryKey = 'IDRegimenH';
    public $timestamps = false;
    protected $fillable = ['descripcionRegimen', 'estado'];
}
