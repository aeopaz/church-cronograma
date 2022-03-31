<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ministerio extends Model
{
    use HasFactory;
    protected $table='ministerios';
    protected $fillable=[
        'nombre',
        'iglesia_id',
        'lider_id',

    ];
}
