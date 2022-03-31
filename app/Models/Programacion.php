<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programacion extends Model
{
    use HasFactory;
    protected $table='programacions';
    protected $fillable=[
        'tipo_programacion_id',
        'iglesia_id',
        'nombre',
        'fecha',
        'hora'
    ];
}
