<?php
/*Muestra y gestiona la programación propia*/

namespace App\Http\Livewire\Programacion;

use App\Models\AsistenciaPrograma;
use App\Models\Iglesia;
use App\Models\Membrecia;
use App\Models\Ministerio;
use App\Models\ParticipantesProgramacionMinisterio;
use App\Models\Programacion;
use App\Models\Recurso;
use App\Models\RecursoProgramacionMinisterio;
use App\Models\Rol;
use App\Models\TipoProgramacion;
use App\Models\User;
use App\Models\UsuarioMinisterio;
use App\Notifications\AsignacionCompromiso;
use App\Notifications\CancelacionCompromiso;
use App\Notifications\EmailAsignacionCompromiso;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jenssegers\Date\Date;

class ProgramacionIndex extends Component
{
    public $idPrograma = 0;
    public $idTipoPrograma;
    public $nombrePrograma;
    public $idLugarPrograma;
    public $nivelPrograma;
    public $fechaPrograma;
    public $horaPrograma;
    public $estadoPrograma;
    public $idMinisterio;
    public $idRol;
    public $idUsuarioParticipante;
    public $idRecurso;
    public $imagenRecurso;
    public $mostrarListaParticipantes = true;
    public $mostrarListaRecursos = true;
    public $tipoVista; //Si es programas generales o propios
    public $pestana = 'programa';
    public $idMiembro;
    public $tipoLlegada;
    public $textoBuscar;

    public function mount($tipoVista)
    {
        $this->tipoVista = $tipoVista;
    }


    public function render()
    {
        $fecha = Carbon::now();

        if ($this->tipoVista == 'propia') {
            //Programas propios
            //Consultar la agenda creada por el usuario
            $programasGenerales = User::find(Auth::user()->id)->programacionPropia()
                ->join('users', 'users.id', 'programacions.user_id')
                ->join('tipo_programacions', 'tipo_programacions.id', 'tipo_programacion_id')
                ->join('iglesias', 'iglesias.id', 'programacions.iglesia_id')
                ->where(function ($query) {
                    $query->where('users.name', 'like', '%' . $this->textoBuscar . '%')
                        ->Orwhere('programacions.fecha', 'like', '%' . $this->textoBuscar . '%')
                        ->Orwhere('programacions.hora', 'like', '%' . $this->textoBuscar . '%')
                        ->Orwhere('iglesias.nombre', 'like', '%' . $this->textoBuscar . '%')
                        ->Orwhere('programacions.nombre', 'like', '%' . $this->textoBuscar . '%')
                        ->Orwhere('tipo_programacions.nombre', 'like', '%' . $this->textoBuscar . '%');
                })->orderBy('fecha', 'asc')
                // ->whereDate('programacions.fecha', '>=', $fecha->format('Y-m-d'))
                ->get([
                    'programacions.id as idPrograma',
                    'programacions.nombre as nombrePrograma',
                    'tipo_programacions.nombre as nombreTipoPrograma',
                    'programacions.estado as estadoPrograma',
                    'fecha',
                    'programacions.hora as horaPrograma',
                    'users.name as nombreUsuarioCreador',
                    'iglesias.nombre as nombreLugar'

                ]);
        } else {
            //Programas Generales
            //Consultar Programas en los que esta inscrito el usuario
            $programasGenerales = User::find(Auth::user()->id)->programacion()
                ->join('programacions', 'programacions.id', 'programacion_id')
                ->join('rols', 'rols.id', 'rol_id')
                ->join('users', 'users.id', 'programacions.user_id')
                ->join('tipo_programacions', 'tipo_programacions.id', 'tipo_programacion_id')
                ->join('iglesias', 'iglesias.id', 'programacions.iglesia_id')
                ->where('programacions.estado', 'A')
                ->whereDate('programacions.fecha', '>=', $fecha->format('Y-m-d'))
                ->where(function ($query) {
                    $query->where('users.name', 'like', '%' . $this->textoBuscar . '%')
                        ->Orwhere('programacions.fecha', 'like', '%' . $this->textoBuscar . '%')
                        ->Orwhere('programacions.hora', 'like', '%' . $this->textoBuscar . '%')
                        ->Orwhere('iglesias.nombre', 'like', '%' . $this->textoBuscar . '%')
                        ->Orwhere('programacions.nombre', 'like', '%' . $this->textoBuscar . '%')
                        ->Orwhere('tipo_programacions.nombre', 'like', '%' . $this->textoBuscar . '%')
                        ->Orwhere('rols.nombre', 'like', '%' . $this->textoBuscar . '%');
                })->orderBy('fecha', 'asc')
                ->get([
                    'programacions.id as idPrograma',
                    'programacions.nombre as nombrePrograma',
                    'tipo_programacions.nombre as nombreTipoPrograma',
                    'programacions.estado as estadoPrograma',
                    'fecha',
                    'programacions.hora as horaPrograma',
                    'users.name as nombreUsuarioCreador',
                    'iglesias.nombre as nombreLugar',
                    'rol_id',
                    'rols.nombre as nombreRol',
                ]);
        }


        //Definir Variables array
        $anosPrograma = [];
        $grupoxAnoxMes = [];
        //Recorrer programas para crear array con los datos agrupados por año y mes
        foreach ($programasGenerales as $programa) {
            //Obtener año y mes de la fecha del programa
            $anoMes = Date::parse($programa->fecha)->format('Y F');
            //Validar si el año y mes del programa se encuentra registrado en el array grupoxAnoxMes
            if (!in_array($anoMes, $grupoxAnoxMes)) {
                //Agregar al array el año y mes del programa
                $grupoxAnoxMes[] = [$anoMes => []];
            }
            //Crear un array con la información de cada programa
            $array = [
                'idPrograma' => $programa->idPrograma,
                'nombrePrograma' => $programa->nombrePrograma,
                'nombreTipoPrograma' => $programa->nombreTipoPrograma,
                'estadoPrograma' => $programa->estadoPrograma,
                'fecha' => $programa->fecha,
                'diaPrograma' => Date::parse($programa->fecha)->format('l j'),
                'horaPrograma' => $programa->horaPrograma,
                'nombreUsuarioCreador' => $programa->nombreUsuarioCreador,
                'nombreLugar' => $programa->nombreLugar,
                'nombreRol' => $programa->nombreRol
            ];
            //Recorrer el array para crear la agrupación
            for ($i = 0; $i < count($grupoxAnoxMes); $i++) {
                //Validar si esta definido  el array con una clave  año y mes
                if (isset($grupoxAnoxMes[$i][$anoMes])) {
                    //Validar si el año y mes del programa es igual al clave del array grupo x ano x mes
                    if ($anoMes == key($grupoxAnoxMes[$i])) {
                        //Adicionar en el array grupoxAnoxMes el array del programa
                        array_push($grupoxAnoxMes[$i][$anoMes], $array);
                    }
                }
            }
            //Validar si dentro del array anosPrograma existe un key anoMes. Este array facilita que se pueda recorrer los años en la vista
            if (!in_array($anoMes, $anosPrograma)) {
                //Adicionar anoMes al array anosPrograma
                $anosPrograma[] = $anoMes;
            }
        }
        //Lugares
        $listaLugares = Iglesia::all(['id', 'nombre']);
        //Tipos de Programa
        $listaTipoPrograma = TipoProgramacion::all(['id', 'nombre']);
        //Ministerios
        $listaMinisterios = Ministerio::all(['id', 'nombre']);
        //Participantes Programa
        $participantes = $this->participantesPrograma($this->idPrograma);
        //Recursos Programa
        $recursosPrograma = $this->recursosPrograma($this->idPrograma);
        //Lista recursos
        $listaRecursos = Recurso::join('tipo_recursos', 'tipo_recursos.id', 'tipo_recurso_id')
            ->get([
                'recursos.nombre as nombreRecurso',
                'recursos.id as idRecurso',
                'tipo_recursos.nombre as nombreTipoRecurso'
            ]);
        //Usuarios por ministerio
        $usuariosMinisterio = UsuarioMinisterio::join('users', 'users.id', 'id_user')
            ->where('id_ministerio', $this->idMinisterio)
            ->where('usuario_ministerio.estado', 'A')
            ->orderBy('nombreUsuario', 'asc')
            ->get(['users.name as nombreUsuario', 'users.id as idUsuario']);
        //Roles
        $roles = Rol::all(['id', 'nombre']);
        //Obtiene el listado de miembros
        $miembros = Membrecia::all(['id', 'nombre', 'apellido']);
        //Obtiene los miembros que asistieron al programa
        $asistenciaMiembros = $this->asistenciaPrograma($this->idPrograma);
        //Retornar datos a la vista
        return view(
            'livewire.programacion.programacion-index',
            compact(
                'programasGenerales',
                'anosPrograma',
                'grupoxAnoxMes',
                'listaTipoPrograma',
                'participantes',
                'recursosPrograma',
                'listaMinisterios',
                'usuariosMinisterio',
                'roles',
                'listaRecursos',
                'listaLugares',
                'miembros',
                'asistenciaMiembros'
            )
        );
    }

    public function create()
    {
        $this->limpiarCampos();
        $this->emit('modal', 'crearProgramaModal', 'show');
    }
    public function store()
    {
        $fechaActual = Carbon::now()->subDay(1)->format('Y-m-d');
        $validateData = $this->validate([
            'idTipoPrograma' => 'required',
            'nombrePrograma' => 'required|string|max:50',
            'idLugarPrograma' => 'required',
            'fechaPrograma' => 'required|date|after:' . $fechaActual,
            'horaPrograma' => 'required|date_format:H:i',
        ]);

        try {
            $programa = Programacion::join('iglesias', 'iglesias.id', 'programacions.iglesia_id')
                ->where('tipo_programacion_id', $this->idTipoPrograma)
                ->where('fecha', $this->fechaPrograma)
                ->where('estado', 'A')->first();
            if ($programa) {
                return session()->flash('fail', 'Ya existe un programa similar para el día y lugar seleccionado.');
            }

            $programa = Programacion::create();
            $programa->tipo_programacion_id = $this->idTipoPrograma;
            $programa->nombre = $this->nombrePrograma;
            $programa->iglesia_id = $this->idLugarPrograma;
            $programa->fecha = $this->fechaPrograma;
            $programa->hora = $this->horaPrograma;
            $programa->user_id = auth()->id();
            $programa->estado = 'A';
            $programa->nivel = 1;
            $programa->save();
            $this->limpiarCampos();
            $this->emit('modal', 'crearProgramaModal', 'hide');
            $this->edit($programa);
            return session()->flash('success', 'Se ha creado el programa satisfactoriamente.');
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }
    //Vista Editar Programa
    public function edit(Programacion $programa)
    {
        //Programa
        $this->idPrograma = $programa->id;
        $this->idTipoPrograma = $programa->tipo_programacion_id;
        $this->nombrePrograma = $programa->nombre;
        $this->idLugarPrograma = $programa->iglesia_id;
        $this->fechaPrograma = $programa->fecha->toDateString();
        $this->horaPrograma = $programa->hora;
        $this->estadoPrograma = $programa->estado;

        $this->emit('modal', 'editarProgramaModal', 'show');
    }
    //Actualizar programa
    public function update($idPrograma)
    {
        $fechaActual = Carbon::now()->subDay(1)->format('Y-m-d');
        $validateData = $this->validate([
            'idTipoPrograma' => 'required',
            'estadoPrograma' => 'required',
            'nombrePrograma' => 'required|string|max:50',
            'idLugarPrograma' => 'required',
            'fechaPrograma' => 'required|date|after:' . $fechaActual,
            'horaPrograma' => 'required|date_format:H:i',
        ]);


        try {
            $programa = Programacion::join('iglesias', 'iglesias.id', 'programacions.iglesia_id')
                ->where('tipo_programacion_id', $this->idTipoPrograma)
                ->where('fecha', $this->fechaPrograma)
                ->where('programacions.id', '<>', $idPrograma)
                ->where('estado', 'A')->first();
            if ($programa) {
                return session()->flash('fail', 'Ya existe un programa similar para el día y lugar seleccionado.');
            }

            $programa = Programacion::find($idPrograma);
            $programa->tipo_programacion_id = $this->idTipoPrograma;
            $programa->nombre = $this->nombrePrograma;
            $programa->iglesia_id = $this->idLugarPrograma;
            $programa->fecha = $this->fechaPrograma;
            $programa->hora = $this->horaPrograma;
            $programa->user_id = auth()->id();
            $programa->estado = $this->estadoPrograma;
            $programa->nivel = 1;
            $programa->save();
            // $this->emit('modal', 'editarProgramaModal', 'hide');
            return session()->flash('success', 'Se ha modificado el programa satisfactoriamente.');
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }

    //Agregar Participantes al Programa
    public function agregarParticipantes()
    {
        $this->validate([
            'idMinisterio' => 'required|numeric',
            'idUsuarioParticipante' => 'required|numeric',
            'idRol' => 'required|numeric',
        ]);

        try {
            //Validar que no exista un usuario creado con el mismo ministerio, programación  y usuario id
            $participante = ParticipantesProgramacionMinisterio::where('programacion_id', $this->idPrograma)
                ->where('ministerio_id', $this->idMinisterio)
                ->where('user_id', $this->idUsuarioParticipante)
                ->where('rol_id', $this->idRol)->first();

            if ($participante) {
                return session()->flash('fail', 'El participante ya se encuentra registrado para ese rol');
            }
            $participante = ParticipantesProgramacionMinisterio::create([
                'programacion_id' => $this->idPrograma,
                'ministerio_id' => $this->idMinisterio,
                'user_id' => $this->idUsuarioParticipante,
                'rol_id' => $this->idRol,
                'user_created_id' => Auth::user()->id
            ]);
            $this->reset(['idMinisterio', 'idUsuarioParticipante', 'idRol']);
            $this->enviarNotificacion($participante, 'asignar');
            return session()->flash('success', 'El participante agregado correctamente');
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }
    //Eliminar Participante
    public function eliminarParticipante($idParticipacion)
    {
        $this->pestana='participante';
        try {
            //Buscar el participante en el programa
            $participacion = ParticipantesProgramacionMinisterio::find($idParticipacion);


            //validar si el participanete existe
            if ($participacion) {
                $this->enviarNotificacion($participacion, 'cancelar');
                $participacion->delete();
                return session()->flash('success', 'El Participante ha sido Eliminado del programa');
            }
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }

    //Obtener Participantes del programa
    public function participantesPrograma($idPrograma)
    {
        $participantes = ParticipantesProgramacionMinisterio::join('programacions', 'programacions.id', 'programacion_id')
            ->join('rols', 'rols.id', 'rol_id')
            ->join('ministerios', 'ministerios.id', 'ministerio_id')
            ->join('users', 'users.id', 'participantes_programacion_ministerios.user_id')
            ->where('programacion_id', $idPrograma)
            ->orderBy('nombreParticipante', 'asc')
            ->get([
                'participantes_programacion_ministerios.id as idParticipacion',
                'programacion_id',
                'ministerio_id',
                'ministerios.nombre as nombre_ministerio',
                'rol_id',
                'rols.nombre as nombreRol',
                'users.id as idUserParticipante',
                'users.name as nombreParticipante',
                'participantes_programacion_ministerios.id as participanteProgramaId',
                'avatar'
            ]);

        return $participantes;
    }
    //Agregar Recursos a programa
    public function agregarRecursosPrograma()
    {
        $this->validate([
            'idMinisterio' => 'required|numeric',
            'idRecurso' => 'required|numeric',

        ]);
        try {

            //Validar que no exista un usuario creado con el mismo ministerio, programación  y usuario id
            $recursoPrograma = RecursoProgramacionMinisterio::where('programacion_id', $this->idPrograma)
                ->where('ministerio_id', $this->idMinisterio)
                ->where('recurso_id', $this->idRecurso)->first();

            if ($recursoPrograma) {
                return session()->flash('fail', 'El Recurso ya se encuentra registrado en el programa');
            }
            RecursoProgramacionMinisterio::create([
                'programacion_id' => $this->idPrograma,
                'ministerio_id' => $this->idMinisterio,
                'recurso_id' => $this->idRecurso,
                'user_created_id' => Auth::user()->id
            ]);
            $this->reset(['idMinisterio', 'idRecurso']);
            return session()->flash('success', 'Recurso agregado correctamente');
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }
    //Eliminar Recursos programa
    public function eliminarRecursoPrograma($idRecursoPrograma)
    {
        $this->pestana='recurso';
        try {
            //Buscar el participante en el programa
            $recursoPrograma = RecursoProgramacionMinisterio::find($idRecursoPrograma);


            //validar si el participanete existe
            if ($recursoPrograma) {
                $recursoPrograma->delete();
                return session()->flash('success', 'El Recurso ha sido Eliminado del programa');
            }
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }

    //Obtener Recursos programa
    public function recursosPrograma($idPrograma)
    {
        $recursos = RecursoProgramacionMinisterio::join('programacions', 'programacions.id', 'programacion_id')
            ->join('ministerios', 'ministerios.id', 'ministerio_id')
            ->join('recursos', 'recursos.id', 'recurso_id')
            ->join('tipo_recursos', 'tipo_recursos.id', 'tipo_recurso_id')
            ->where('programacion_id', $idPrograma)
            ->get([
                'recurso_programacion_ministerios.id as idRecursoPrograma',
                'programacion_id',
                'ministerios.id as ministerio_id',
                'ministerios.nombre as nombre_ministerio',
                'recurso_id',
                'tipo_recursos.nombre as tipoRecurso',
                'recursos.nombre as nombreRecurso',
                'url',
                'recurso_programacion_ministerios.id as recursoProgramaId',
            ]);

        return $recursos;
    }

    //Obtener los miembros que han asistido a un programa
    public function asistenciaPrograma($idPrograma)
    {
        return AsistenciaPrograma::join('membrecias', 'membrecias.id', 'asistencia_programas.id_miembro')
            ->where('id_programa', $idPrograma)->get([
                'asistencia_programas.id as idAsistencia',
                'membrecias.nombre as nombreMiembro',
                'membrecias.apellido as apellidoMiembro',
                'tipo_llegada as tipoLlegada'
            ]);
    }
    public function limpiarCampos()
    {
        $this->reset(['idTipoPrograma', 'nombrePrograma', 'fechaPrograma', 'horaPrograma']);
    }

    //Mostrar modal con la imagen del recurso
    public function verRecurso($idRecurso)
    {
        $recurso = Recurso::find($idRecurso);
        $this->imagenRecurso = $recurso->url;
        $this->emit('modal', 'verRecursoModal', 'show');
    }
    //Ocultar modal con la imagen del recurso
    public function ocultarVerRecurso()
    {
        $this->emit('modal', 'verRecursoModal', 'hide');
    }

    //Registrar asistencia de miembros al programa
    public function registrarAsistencia()
    {
        //Mantener pestaña asistencia
        $this->pestana='asistencia';
        //Validar Campos
        $this->validate([
            'idMiembro' => 'required',
            'tipoLlegada' => 'required'
        ]);
        try {
            //Validar que si exista en la tabla Miembros
            $miembro = Membrecia::find($this->idMiembro);
            if (!$miembro) {
                return session()->flash('fail', 'El miembro no se encuentra registrado');
            }
            //Validar que no se encuentre registrado en la tabla asistencia
            $asistenciaMiembro = AsistenciaPrograma::where('id_programa', $this->idPrograma)->where('id_miembro', $this->idMiembro)->first();
            if ($asistenciaMiembro) {
                return session()->flash('fail', 'El miembro ya se encuentra registrado');
            }
            //Traer fecha conversión para calcular tipo de miembro
            $tipoMiembro = $miembro->fecha_conversion->diffInMonths() < 3 ? 'Nuevo' : 'Antiguo';
            $asistenciaMiembro = AsistenciaPrograma::create();
            $asistenciaMiembro->id_programa = $this->idPrograma;
            $asistenciaMiembro->id_miembro = $this->idMiembro;
            $asistenciaMiembro->id_usuario = auth()->id();
            $asistenciaMiembro->tipo_llegada = $this->tipoLlegada;
            $asistenciaMiembro->tipo_miembro = $tipoMiembro;
            $asistenciaMiembro->save();
            $this->reset(['idMiembro', 'tipoLlegada']);
            return session()->flash('success', 'Se ha registrado la asistencia');
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }
    //Eliminar asistencia de miembros al programa
    public function eliminarAsistencia($idMiembro)
    {
        $this->pestana='asistencia';
        try {

            $asistenciaMiembro = AsistenciaPrograma::find($idMiembro);
            $asistenciaMiembro->delete();
            return session()->flash('success', 'Se ha eliminado la asistencia');
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }

    public function enviarNotificacion($participacion, $tipoNotificación)
    {
        try {
            $participantePrograma = ParticipantesProgramacionMinisterio::join('programacions', 'programacions.id', 'programacion_id')
                ->join('rols', 'rols.id', 'rol_id')
                ->join('ministerios', 'ministerios.id', 'ministerio_id')
                ->join('users', 'users.id', 'participantes_programacion_ministerios.user_id')
                ->join('iglesias', 'iglesias.id', 'programacions.iglesia_id')
                ->where('participantes_programacion_ministerios.id', $participacion->id)
                ->first([
                    'programacion_id',
                    'programacions.user_id as idOrganizador',
                    'programacions.nombre as nombrePrograma',
                    'fecha as fechaPrograma',
                    'hora as horaProgram',
                    'iglesias.nombre as lugar',
                    'ministerio_id',
                    'ministerios.nombre as nombreMinisterio',
                    'rol_id',
                    'rols.nombre as nombreRol',
                    'users.id as idUserParticipante',
                    'users.name as nombreParticipante',
                    'participantes_programacion_ministerios.id as participanteProgramaId',
                    'participantes_programacion_ministerios.id as idParticipacion',
                    'avatar'

                ]);
            //Consultar el usuario al que se le enviará la notificación
            $usuarioParticipante = User::find($participacion->user_id);
            //Enviar Notificación
            if ($tipoNotificación == 'asignar') {
                $usuarioParticipante->notify(new AsignacionCompromiso($participantePrograma));
            } else {
                $usuarioParticipante->notify(new CancelacionCompromiso($participantePrograma));
            }
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error al Enviar la notificación, contacte al administrador del sistema.');
        }
    }

    public function camposAgregarParticipantes()
    {

        if ($this->mostrarListaParticipantes) {
            $this->mostrarListaParticipantes = false;
        }

        $this->pestana = 'participante';
    }
    public function camposAgregarRecurso()
    {

        if ($this->mostrarListaRecursos) {
            $this->mostrarListaRecursos = false;
        }

        $this->pestana = 'recurso';
    }
}





// DB::raw("DATE_FORMAT(fecha,'%Y') as ano"),
            // DB::raw("DATE_FORMAT(fecha,'%Y %M') as dd"),
            // DB::raw("DATE_FORMAT(fecha,'%M') as mes"),