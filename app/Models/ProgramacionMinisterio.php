<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramacionMinisterio extends Model
{
    use HasFactory;
    protected $table='programacion_ministerios';
    protected $fillable=[
        'programacion_id',
        'ministerio_id',
       
    ];
}
