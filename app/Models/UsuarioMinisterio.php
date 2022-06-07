<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioMinisterio extends Model
{
    use HasFactory;
    protected $table='usuario_ministerio';
    protected $fillable=[
        'id_user',
        'id_ministerio'
    ];
}
