<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;
    protected $table='publicacions';
    protected $fillabe=[
        'id_usuario',
        'id_tipo_publicacion',
        'titulo',
        'cuerpo',
        'ruta_archivo',
        
    ];
}
