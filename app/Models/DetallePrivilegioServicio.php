<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePrivilegioServicio extends Model
{
    use HasFactory;
    protected $table='detalle_privilegio_servicios';
    protected $fillable=[
        'id_servicio',
        'id_privilegio',
        'id_publicacion'
    ];
}
