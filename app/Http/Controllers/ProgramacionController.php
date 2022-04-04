<?php

namespace App\Http\Controllers;

use App\Models\ParticipantesProgramacionMinisterio;
use App\Models\Programacion;
use App\Models\RecursoProgramacionMinisterio;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProgramacionController extends Controller
{
    //Traer los programas en los que esta inscrito el usuario autenticado
    public function user_program()
    {
        $data = User::find(Auth::user()->id)->programacion()
            ->join('programacions', 'programacions.id', 'programacion_id')
            ->join('rols', 'rols.id', 'rol_id')
            ->join('ministerios', 'ministerios.id', 'ministerio_id')
            ->orderBy('programacions.fecha', 'desc')
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

    //Traer los participantes de un sólo programa
    public function participantes_program($programacion_id)
    {

        $data = ParticipantesProgramacionMinisterio::join('programacions', 'programacions.id', 'programacion_id')
            ->join('rols', 'rols.id', 'rol_id')
            ->join('ministerios', 'ministerios.id', 'ministerio_id')
            ->join('users', 'users.id', 'participantes_programacion_ministerios.user_id')
            ->where('programacion_id', $programacion_id)
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
    //Traer los recursos de un sólo programa
    public function recursos_program($programacion_id)
    {

        $data = RecursoProgramacionMinisterio::join('programacions', 'programacions.id', 'programacion_id')
            ->join('ministerios', 'ministerios.id', 'ministerio_id')
            ->join('recursos', 'recursos.id', 'recurso_id')
            ->join('tipo_recursos', 'tipo_recursos.id', 'tipo_recurso_id')
            ->where('programacion_id', $programacion_id)
            ->get([
                'programacion_id',
                'ministerios.id as ministerio_id',
                'ministerios.nombre as nombre_ministerio',
                'recurso_id',
                'tipo_recursos.nombre as tipo_recurso',
                'recursos.nombre as nombre_recurso',
            ]);

        return response()->json(compact('data'));
    }
    //Traer los programas que ha creado el usuario autenticado
    public function own_program()
    {
        $data = User::find(Auth::user()->id)->programacionPropia()->join('tipo_programacions', 'tipo_programacions.id', 'tipo_programacion_id')->orderBy('programacions.fecha', 'desc')->get(
            [
                'programacions.id as programacion_id',
                'tipo_programacion_id',
                'tipo_programacions.nombre as nombre_tipo_programacion',
                'programacions.nombre as nombre_programa',
                'programacions.fecha as fecha_programa',
                'programacions.hora as hora_programa',
            ]

        );
        return response()->json(compact('data'));
    }
    //Crear una agenda o programacion
    public function store(Request $request)
    {
        $fechaActual = Carbon::now();
        $validator = Validator::make($request->all(), [
            'tipo_programacion_id' => 'required|numeric',
            'nombre' => 'required|string|max:60',
            'fecha' => 'required|after_or_equal:' . $fechaActual,
            'hora' => 'required|date_format:H:i'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $programacion = Programacion::create([
            'tipo_programacion_id' => $request->tipo_programacion_id,
            'iglesia_id' => 1,
            'nombre' => $request->nombre,
            'user_id' => Auth::user()->id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
        ]);

        return response()->json(compact('programacion'), 201);
    }

    //Consulta una agenda o programacion
    public function show($programacion_id)
    {
        $programacion = Programacion::find($programacion_id, ['tipo_programacion_id', 'nombre', 'fecha', 'hora']);

        return response()->json(compact('programacion'));
    }
    //Actualizar una agenda o programacion
    public function update(Request $request, $programacion_id)
    {
        $fechaActual = Carbon::now();
        $validator = Validator::make($request->all(), [
            'tipo_programacion_id' => 'required|numeric',
            'nombre' => 'required|string|max:60',
            'fecha' => 'required|after_or_equal:' . $fechaActual,
            'hora' => 'required|date_format:H:i'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $programacion = Programacion::find($programacion_id);
        if ($programacion) {
            $programacion->tipo_programacion_id = $request->tipo_programacion_id;
            $programacion->nombre = $request->nombre;
            $programacion->fecha = $request->fecha;
            $programacion->hora = $request->hora;
            $programacion->save();
            return response()->json(compact('programacion'), 201);
        } else {
            return response()->json('El programa no existe', 404);
        }
    }

    //Agregar Participante a programación
    public function add_users(Request $request, $programacion_id)
    {

        $validator = Validator::make($request->all(), [
            'ministerio_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'rol_id' => 'required|numeric',

        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        //Validar que no exista un usuario creado con el mismo ministerio, programación  y usuario id
        $validarParticipanete = ParticipantesProgramacionMinisterio::where('programacion_id', $programacion_id)
            ->where('ministerio_id', $request->ministerio_id)
            ->where('user_id', $request->user_id)
            ->where('rol_id', $request->rol_id)->first();

        if ($validarParticipanete) {
            return response()->json('El usuario ya existe', 403);
        }
        $participante = ParticipantesProgramacionMinisterio::create([
            'programacion_id' => $programacion_id,
            'ministerio_id' => $request->ministerio_id,
            'user_id' => $request->user_id,
            'rol_id' => $request->rol_id,
            'user_created_id' => Auth::user()->id
        ]);

        return response()->json(compact('participante'), 201);
    }

    //Eliminar Participante de programación

    public function delete_participante($participanteProgramaId)
    {
        //Buscar el participante en el programa
        $participante = ParticipantesProgramacionMinisterio::find($participanteProgramaId);
        //validar si el participanete existe
        if ($participante) {
            $participante->delete();
            return response()->json('El Participante ha sido Eliminado', 200);
        } else {
            return response()->json('El Participante no existe', 404);
        }
    }
    //Agregar Recursos a programación
    public function add_resource(Request $request, $programacion_id)
    {

        $validator = Validator::make($request->all(), [
            'ministerio_id' => 'required|numeric',
            'recurso_id' => 'required|numeric',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        //Validar que no exista un usuario creado con el mismo ministerio, programación  y usuario id
        $validarRecurso = RecursoProgramacionMinisterio::where('programacion_id', $programacion_id)
            ->where('ministerio_id', $request->ministerio_id)
            ->where('recurso_id', $request->recurso_id)->first();

        if ($validarRecurso) {
            return response()->json('El recurso ya existe', 403);
        }
        $recurso = RecursoProgramacionMinisterio::create([
            'programacion_id' => $programacion_id,
            'ministerio_id' => $request->ministerio_id,
            'recurso_id' => $request->recurso_id,
            'user_created_id' => Auth::user()->id
        ]);

        return response()->json(compact('recurso'), 201);
    }
    public function delete_recurso($participanteProgramaId)
    {
        //Buscar el participante en el programa
        $recurso = RecursoProgramacionMinisterio::find($participanteProgramaId);
        //validar si el participanete existe
        if ($recurso) {
            $recurso->delete();
            return response()->json('El Recurso ha sido Eliminado', 200);
        } else {
            return response()->json('El Recurso no existe', 404);
        }
    }
}
