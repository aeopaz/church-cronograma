<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleServicio extends Model
{
    use HasFactory;
    protected $table='detalle_servicios';
    protected $fillabe=[
        'id_servicio',
        'id_privilegio',
        'id_responsable'
    ];
}
