<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iglesia extends Model
{
    use HasFactory;
    protected $table='iglesias';
    protected $fillabe=[
        'nombre',
        'direccion',
        'telefono',
        'email'
    ];
}
