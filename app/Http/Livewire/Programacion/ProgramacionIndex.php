<?php
/*Muestra y gestiona la programación propia*/

namespace App\Http\Livewire\Programacion;

use App\Models\Ministerio;
use App\Models\ParticipantesProgramacionMinisterio;
use App\Models\Programacion;
use App\Models\Recurso;
use App\Models\RecursoProgramacionMinisterio;
use App\Models\Rol;
use App\Models\TipoProgramacion;
use App\Models\User;
use App\Models\UsuarioMinisterio;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProgramacionIndex extends Component
{
    public $idPrograma;
    public $idTipoPrograma;
    public $nombrePrograma;
    public $nivelPrograma;
    public $fechaPrograma;
    public $horaPrograma;
    public $estadoPrograma;
    public $idMinisterio;
    public $idRol;
    public $idUsuarioParticipante;
    public $idRecurso;
    public $mostrarListaParticipantes = true;
    public $mostrarListaRecursos = true;
    public $tipoVista;

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
                // ->where('programacions.estado', 'Activo')
                ->orderBy('fecha', 'asc')
                // ->whereDate('programacions.fecha', '>=', $fecha->format('Y-m-d'))
                ->get([
                    'programacions.id as idPrograma',
                    'programacions.nombre as nombrePrograma',
                    'tipo_programacions.nombre as nombreTipoPrograma',
                    'programacions.estado as estadoPrograma',
                    'fecha',
                    'programacions.hora as horaPrograma',
                    'users.name as nombreUsuarioCreador'
                ]);
        } else {
            //Programas Generales
            //Consultar Programas en los que esta inscrito el usuario
            $programasGenerales = User::find(Auth::user()->id)->programacion()
                ->join('programacions', 'programacions.id', 'programacion_id')
                ->join('users', 'users.id', 'programacions.user_id')
                ->join('tipo_programacions', 'tipo_programacions.id', 'tipo_programacion_id')
                ->where('programacions.estado', 'Activo')
                ->orderBy('fecha', 'asc')
                // ->whereDate('programacions.fecha', '>=', $fecha->format('Y-m-d'))
                ->get([
                    'programacions.id as idPrograma',
                    'programacions.nombre as nombrePrograma',
                    'tipo_programacions.nombre as nombreTipoPrograma',
                    'programacions.estado as estadoPrograma',
                    'fecha',
                    'programacions.hora as horaPrograma',
                    'users.name as nombreUsuarioCreador'
                ]);
        }


        //Definir Variables array
        $anosPrograma = [];
        $grupoxAnoxMes = [];
        //Recorrer programas para crear array con los datos agrupados por año y mes
        foreach ($programasGenerales as $programa) {
            //Obtener año y mes de la fecha del programa
            $anoMes = Carbon::parse($programa->fecha)->format('Y F');
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
                'diaPrograma' => Carbon::parse($programa->fecha)->format('l j'),
                'horaPrograma' => $programa->horaPrograma,
                'nombreUsuarioCreador' => $programa->nombreUsuarioCreador,
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
        //Tipos de Programa
        $listaTipoPrograma = TipoProgramacion::all();
        //Ministerios
        $listaMinisterios = Ministerio::all();
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
            ->where('estado', 'A')
            ->orderBy('nombreUsuario', 'asc')
            ->get(['users.name as nombreUsuario', 'users.id as idUsuario']);
        //Roles
        $roles = Rol::all(['id', 'nombre']);

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
                'listaRecursos'
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
        $fechaActual = Carbon::now();
        $validateData = $this->validate([
            'idTipoPrograma' => 'required',
            'nombrePrograma' => 'required|string|max:50',
            'fechaPrograma' => 'required|date|after:' . $fechaActual,
            'horaPrograma' => 'required|date_format:H:i',
        ]);

        try {
            $programa = Programacion::where('tipo_programacion_id', $this->idTipoPrograma)->where('fecha', $this->fechaPrograma)->first();
            if ($programa) {
                return session()->flash('fail', 'Ya existe un programa similar para el día seleccionado.');
            }

            $programa = Programacion::create();
            $programa->tipo_programacion_id = $this->idTipoPrograma;
            $programa->nombre = $this->nombrePrograma;
            $programa->fecha = $this->fechaPrograma;
            $programa->hora = $this->horaPrograma;
            $programa->user_id = auth()->id();
            $programa->estado = 'Activo';
            $programa->nivel = 1;
            $programa->save();
            $this->limpiarCampos();
            $this->emit('modal', 'crearProgramaModal', 'hide');
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
        $this->fechaPrograma = $programa->fecha->toDateString();
        $this->horaPrograma = $programa->hora;
        $this->estadoPrograma = $programa->estado;

        $this->emit('modal', 'editarProgramaModal', 'show');
    }
    //Actualizar programa
    public function update($idPrograma)
    {
        $fechaActual = Carbon::now();
        $validateData = $this->validate([
            'idTipoPrograma' => 'required',
            'estadoPrograma' => 'required',
            'nombrePrograma' => 'required|string|max:50',
            'fechaPrograma' => 'required|date|after:' . $fechaActual,
            'horaPrograma' => 'required|date_format:H:i',
        ]);

        try {
            $programa = Programacion::where('tipo_programacion_id', $this->idTipoPrograma)->where('fecha', $this->fechaPrograma)->where('id', '<>', $idPrograma)->first();
            if ($programa) {
                return session()->flash('fail', 'Ya existe un programa similar para el día seleccionado.');
            }

            $programa = Programacion::find($idPrograma);
            $programa->tipo_programacion_id = $this->idTipoPrograma;
            $programa->nombre = $this->nombrePrograma;
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
                return session()->flash('fail', 'El participante ya se encuentra registrado');
            }
            $participante = ParticipantesProgramacionMinisterio::create([
                'programacion_id' => $this->idPrograma,
                'ministerio_id' => $this->idMinisterio,
                'user_id' => $this->idUsuarioParticipante,
                'rol_id' => $this->idRol,
                'user_created_id' => Auth::user()->id
            ]);
            $this->reset(['idMinisterio', 'idUsuarioParticipante', 'idRol']);
            return session()->flash('success', 'El participante agregado correctamente');
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }
    //Eliminar Participante
    public function eliminarParticipante($idParticipacion)
    {
        try {
            //Buscar el participante en el programa
            $participacion = ParticipantesProgramacionMinisterio::find($idParticipacion);


            //validar si el participanete existe
            if ($participacion) {
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
    public function limpiarCampos()
    {
        $this->reset(['idTipoPrograma', 'nombrePrograma', 'fechaPrograma', 'horaPrograma']);
    }
}
// DB::raw("DATE_FORMAT(fecha,'%Y') as ano"),
            // DB::raw("DATE_FORMAT(fecha,'%Y %M') as dd"),
            // DB::raw("DATE_FORMAT(fecha,'%M') as mes"),