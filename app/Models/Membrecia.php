<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membrecia extends Model
{
    use HasFactory;
    protected $table='membrecias';
    protected $dates=[
        'fecha_nacimiento'
    ];
    protected $fillable=[
        'tipo_documento',
        'numero_documento',
        'nombre',
        'apellido',
        'sexo',
        'estado_civil',
        'celular',
        'email',
        'ciudad',
        'barrio',
        'direccion',

    ];
}
