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
        'fecha_desde',
        'fecha_hasta'
    ];
    protected $fillable = [
        'tipo_programacion_id',
        'iglesia_id',
        'user_id',
        'nombre',
        'hora',
        'observaciones',
        'id_google_event',
    ];

    public function getMesDiaAttribute()
    {
        return Carbon::parse($this->fecha)->format('M j');
    }
}
