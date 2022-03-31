<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramacionController extends Controller
{
    //Traer los programas en los que esta inscrito el usuario autenticado
    public function user_program()
    {
        return User::find(Auth::user()->id)->programacion()
            ->join('programacions', 'programacions.id', 'programacion_id')
            ->get([
                'programacion_id',
                'ministerio_id',
                'programacions.nombre as nombre_programa',
                'programacions.fecha as fecha_programa',
                'programacions.hora as hora_programa',
            ]);
    }
}
