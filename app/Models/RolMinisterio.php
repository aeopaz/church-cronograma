<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolMinisterio extends Model
{
    use HasFactory;
    protected $table='rol_ministerios';
    protected $fillabe=[
        'id_ministerio',
        'nombre',
       
        
    ];
}
