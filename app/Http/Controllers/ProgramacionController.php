<?php

namespace App\Http\Controllers;

use App\Models\ParticipantesProgramacionMinisterio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramacionController extends Controller
{
    //Traer los programas en los que esta inscrito el usuario autenticado
    public function user_program()
    {
        $data = User::find(Auth::user()->id)->programacion()
            ->join('programacions', 'programacions.id', 'programacion_id')
            ->join('rols', 'rols.id', 'rol_id')
            ->join('ministerios', 'ministerios.id', 'ministerio_id')
            ->orderBy('programacions.fecha','desc')
            ->get([
                'programacion_id',
                'ministerio_id',
                'ministerios.nombre as nombre_ministerio',
                'programacions.nombre as nombre_programa',
                'programacions.fecha as fecha_programa',
                'programacions.hora as hora_programa',
                'rol_id',
                'rols.nombre as nombre_rol'
            ]);
        return response()->json(compact('data'));
    }

    //Traer la información de un sólo programa
    public function participantes_program($programacion_id)
    {
        
        $data = ParticipantesProgramacionMinisterio::join('programacions', 'programacions.id', 'programacion_id')
            ->join('rols', 'rols.id', 'rol_id')
            ->join('ministerios', 'ministerios.id', 'ministerio_id')
            ->join('users', 'users.id', 'participantes_programacion_ministerios.user_id')
            ->where('programacion_id',$programacion_id)
            ->get([
                'programacion_id',
                'ministerio_id',
                'ministerios.nombre as nombre_ministerio',
                'rol_id',
                'rols.nombre as nombre_rol',
                'users.id as user_id_participante',
                'users.name as nombre_user'
            ]);
        return response()->json(compact('data'));
    }
}
