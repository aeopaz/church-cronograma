<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programacion extends Model
{
    use HasFactory;
    protected $table = 'programacions';
    protected $dates = [
        'fecha'
    ];
    protected $fillable = [
        'tipo_programacion_id',
        'iglesia_id',
        'user_id',
        'nombre',
        'fecha',
        'hora'
    ];

    public function getMesDiaAttribute()
    {
        return Carbon::parse($this->fecha)->format('M j');
    }
}
