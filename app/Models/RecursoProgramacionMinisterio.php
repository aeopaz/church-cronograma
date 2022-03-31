<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecursoProgramacionMinisterio extends Model
{
    use HasFactory;
    protected $table='recurso_programacion_ministerios';
    protected $fillable=[
        'programacion_id',
        'ministerio_id',
        'recurso_id',
        'ministerio_id'
       
    ];
}
