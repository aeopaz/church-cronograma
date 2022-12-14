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

use function PHPUnit\Framework\isNull;

class ProgramacionIndex extends Component
{
    public $idPrograma = 0;
    public $idTipoPrograma;
    public $nombrePrograma;
    public $idLugarPrograma;
    public $nivelPrograma = 1;
    public $fechaProgramaDesde;
    public $fechaProgramaHasta;
    public $horaPrograma;
    public $estadoPrograma;
    public $idMinisterio;
    public $idRol;
    public $idUsuarioParticipante;
    public $idRecurso;
    public $imagenRecurso;
    public $extensionRecurso;
    public $nombreRecurso;
    public $mostrarListaParticipantes = true;
    public $mostrarListaRecursos = true;
    public $tipoVista; //Si es programas generales o propios
    public $pestana = 'programa';
    public $idMiembro;
    public $tipoLlegada;
    public $textoBuscar;
    public $urlConsultaEventos;
    public $tipoAgenda, $tipoPrograma, $lugar; //Variables para los filtros
    public $observaciones;



    protected $listeners = ['create', 'edit'];

    /**
     * Para obtener los eventos, se recibe la variabel $tipoAgenda así:
     * En la ruta /programacion/index/{tipoAgenda} se envía el tipo de agenda, que puede ser propios o generales
     * Esa variable se recibe en la vista resources\views\programacion\index.blade.php
     * En la vista resources\views\programacion\index.blade.php se envía a este componente la variable $tipoAgenda
     * Luego, desde este componente livewire se pasa a la vista resources\views\livewire\programacion\programacion-index.blade.php
     * La vista anterior se encarga de ejecutar la ruta /eventos/{tipoAgenda} en el calendario. Ver método eventos() en el controlador ProgramacionController
     */
    public function mount($tipoAgenda, $tipoPrograma, $lugar)
    {

        if ($tipoPrograma>0 && $lugar>0) {
            $this->urlConsultaEventos = "/eventos/$tipoAgenda/$tipoPrograma/$lugar";
        } elseif ($tipoPrograma>0) {
            $this->urlConsultaEventos = "/eventos/$tipoAgenda/$tipoPrograma";
        } elseif ($lugar>0) {
            $this->urlConsultaEventos = "/eventos/$tipoAgenda/0/$lugar";
        } else {
            $this->urlConsultaEventos = "/eventos/$tipoAgenda";
        }

        $this->tipoAgenda = $tipoAgenda;
        $this->tipoPrograma = $tipoPrograma;
        $this->lugar = $lugar;
    }


    public function render()
    {
        //Lugares
        $listaLugares = Iglesia::orderBy('nombre', 'asc', ['id', 'nombre'])->get();
        //Tipos de Programa
        $listaTipoPrograma = TipoProgramacion::orderBy('nombre', 'asc', ['id', 'nombre'])->get();
        //Ministerios
        $listaMinisterios = Ministerio::orderBy('nombre', 'asc', ['id', 'nombre'])->get();
        //Participantes Programa
        $participantes = $this->participantesPrograma($this->idPrograma);
        //Recursos Programa
        $recursosPrograma = $this->recursosPrograma($this->idPrograma);
        //Lista recursos
        $listaRecursos = Recurso::join('tipo_recursos', 'tipo_recursos.id', 'tipo_recurso_id')
            ->orderBy('recursos.nombre', 'asc')
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
        $roles = Rol::orderBy('nombre', 'asc', ['id', 'nombre'])->get();
        //Obtiene el listado de miembros
        $miembros = Membrecia::orderBy('nombre', 'asc', ['id', 'nombre', 'apellido'])->get();
        //Obtiene los miembros que asistieron al programa
        $asistenciaMiembros = $this->asistenciaPrograma($this->idPrograma);
        //Retornar datos a la vista
        return view(
            'livewire.programacion.programacion-index',
            compact(
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

    //Vista crear programa
    public function create($fecha)
    {
        $this->limpiarCampos();
        $this->fechaProgramaDesde = $fecha;
        $this->fechaProgramaHasta = $fecha;
        $this->emit('modal', 'crearProgramaModal', 'show');
    }
    //Crear programa
    public function store()
    {
        $fechaActual = Carbon::now()->subDay(1)->format('Y-m-d');
        $validateData = $this->validate([
            'idTipoPrograma' => 'required',
            'nombrePrograma' => 'required|string|max:50',
            'idLugarPrograma' => 'required',
            'fechaProgramaDesde' => 'required|date|after:' . $fechaActual,
            'fechaProgramaHasta' => 'required|date|after_or_equal:fechaProgramaDesde',
            'horaPrograma' => 'required|date_format:H:i',
            'nivelPrograma' => 'required|in:1,2',
            'observaciones'=>'nullable|string|max:200'
        ]);

        try {
            DB::beginTransaction();
            $programa = Programacion::join('iglesias', 'iglesias.id', 'programacions.iglesia_id')
                ->where('tipo_programacion_id', $this->idTipoPrograma)
                ->where('fecha_desde', $this->fechaProgramaDesde)
                ->where('estado', 'A')->first();
            if ($programa) {
                return session()->flash('fail', 'Ya existe un programa similar para el día y lugar seleccionado.');
            }

            $programa = Programacion::create();
            $programa->tipo_programacion_id = $this->idTipoPrograma;
            $programa->nombre = $this->nombrePrograma;
            $programa->iglesia_id = $this->idLugarPrograma;
            $programa->fecha_desde = $this->fechaProgramaDesde;
            $programa->fecha_hasta = $this->fechaProgramaHasta;
            $programa->hora = $this->horaPrograma;
            $programa->user_id = auth()->id();
            $programa->estado = 'A';
            $programa->nivel = $this->nivelPrograma;
            $programa->observaciones=$this->observaciones;
            $programa->save();
            //Asociar usuario creador al evento que acabó de crear
            ParticipantesProgramacionMinisterio::create([
                'programacion_id' => $programa->id,
                'ministerio_id' => 13, //Eventos
                'user_id' => Auth::user()->id,
                'rol_id' => 19, //Organizador de evento
                'user_created_id' => Auth::user()->id
            ]);
            $this->limpiarCampos();
            $this->emit('modal', 'crearProgramaModal', 'hide');
            $this->edit($programa->id);
            $this->emit('refreshCalendar');
            DB::commit();
            return session()->flash('success', 'Se ha creado el programa satisfactoriamente.');
        } catch (\Throwable $th) {
            DB::rollBack();
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }
    //Vista Editar Programa
    public function edit($idPrograma)
    {
        //Programa
        $programa = Programacion::find($idPrograma);
        $this->idPrograma = $programa->id;
        $this->idTipoPrograma = $programa->tipo_programacion_id;
        $this->nombrePrograma = $programa->nombre;
        $this->idLugarPrograma = $programa->iglesia_id;
        $this->fechaProgramaDesde = $programa->fecha_desde->toDateString();
        $this->fechaProgramaHasta = $programa->fecha_hasta->toDateString();
        $this->horaPrograma = $programa->hora;
        $this->estadoPrograma = $programa->estado;
        $this->nivelPrograma = $programa->nivel;
        $this->observaciones=$programa->observaciones;

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
            'fechaProgramaDesde' => 'required|date|after:' . $fechaActual,
            'fechaProgramaHasta' => 'nullable|date|after_or_equal:fechaProgramaDesde',
            'horaPrograma' => 'required|date_format:H:i',
            'nivelPrograma' => 'required|in:1,2',
            'observaciones'=>'nullable|string|max:200'
        ]);


        try {
            $programa = Programacion::join('iglesias', 'iglesias.id', 'programacions.iglesia_id')
                ->where('tipo_programacion_id', $this->idTipoPrograma)
                ->where('fecha_desde', $this->fechaProgramaDesde)
                ->where('programacions.id', '<>', $idPrograma)
                ->where('estado', 'A')->first();
            if ($programa) {
                return session()->flash('fail', 'Ya existe un programa similar para el día y lugar seleccionado.');
            }

            $programa = Programacion::find($idPrograma);
            $programa->tipo_programacion_id = $this->idTipoPrograma;
            $programa->nombre = $this->nombrePrograma;
            $programa->iglesia_id = $this->idLugarPrograma;
            $programa->fecha_desde = $this->fechaProgramaDesde;
            $programa->fecha_hasta = $this->fechaProgramaHasta;
            $programa->hora = $this->horaPrograma;
            $programa->user_id = auth()->id();
            $programa->estado = $this->estadoPrograma;
            $programa->nivel = $this->nivelPrograma;
            $programa->observaciones=$this->observaciones;
            $programa->save();
            $this->emit('refreshCalendar');
            $this->emit('modal', 'editarProgramaModal', 'hide');
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
        $this->pestana = 'participante';
        try {
            //Buscar el participante en el programa
            $participacion = ParticipantesProgramacionMinisterio::find($idParticipacion);


            //validar si el participanete existe
            if ($participacion) {
                //Validar si el participante tiene el rol de Organizador para evitar su eliminación
                if ($participacion->rol_id == 19) {
                    return session()->flash('fail', 'El Participante organizador no se puede eliminar');
                }
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
        $this->pestana = 'recurso';
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
            ->orderBy('recursos.nombre', 'asc')
            ->get([
                'recurso_programacion_ministerios.id as idRecursoPrograma',
                'programacion_id',
                'ministerios.id as ministerio_id',
                'ministerios.nombre as nombre_ministerio',
                'recurso_id',
                'tipo_recursos.nombre as tipoRecurso',
                'recursos.nombre as nombreRecurso',
                'url',
                'extension',
                'recurso_programacion_ministerios.id as recursoProgramaId',
            ]);

        return $recursos;
    }

    //Obtener los miembros que han asistido a un programa
    public function asistenciaPrograma($idPrograma)
    {
        return AsistenciaPrograma::join('membrecias', 'membrecias.id', 'asistencia_programas.id_miembro')
            ->where('id_programa', $idPrograma)
            ->orderBy('membrecias.nombre', 'asc')
            ->get([
                'asistencia_programas.id as idAsistencia',
                'membrecias.nombre as nombreMiembro',
                'membrecias.apellido as apellidoMiembro',
                'tipo_llegada as tipoLlegada'
            ]);
    }
    public function limpiarCampos()
    {
        $this->reset(['idTipoPrograma', 'nombrePrograma', 'fechaProgramaDesde', 'fechaProgramaHasta', 'horaPrograma','observaciones']);
    }

    //Mostrar modal con la imagen del recurso
    public function verRecurso($idRecurso)
    {
        $recurso = Recurso::find($idRecurso);
        $this->imagenRecurso = $recurso->url;
        $this->nombreRecurso = $recurso->nombre;
        $this->extensionRecurso = $recurso->extension;
        $this->pestana = 'recurso';
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
        $this->pestana = 'asistencia';
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
        $this->pestana = 'asistencia';
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