<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantesProgramacionMinisterio extends Model
{
    use HasFactory;
    protected $table='participantes_programacion_ministerios';
    protected $fillable=[
        'programacion_id',
        'ministerio_id',
        'user_id',
        'rol_id'
    ];

}
