<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    use HasFactory;
    protected $table='recursos';
    protected $fillable=[
        'nombre',
        'url',
        'tipo_recurso_id',
        'ministerio_id'
       
    ];
}
