<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleMinisterio extends Model
{
    use HasFactory;
    protected $table='detalle_ministerios';
    protected $fillable=[
        'id_ministerio',
        'id_integrante',
        'id_rol'
    ];
}
