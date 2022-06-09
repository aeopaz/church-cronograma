<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaPrograma extends Model
{
    use HasFactory;
    protected $table='asistencia_programas';
    protected $fillable=[
        'id_programa',
        'id_miembro',
        'id_usuario'
    ];
}
