<?php

namespace App\Http\Livewire\Reportes;

use App\Models\AsistenciaPrograma;
use App\Models\Iglesia;
use App\Models\Membrecia;
use App\Models\ParticipantesProgramacionMinisterio;
use App\Models\Programacion;
use App\Models\TipoProgramacion;
use App\Models\User;
use Carbon\Carbon;
use App\Traits\FuncionesTrait;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReportesIndex extends Component
{
    use FuncionesTrait;
    use WithPagination;
    public $totales;
    public $tipoReporte;
    public $idUsuarioLogueado;
    public $idOrganizadorPrograma = '%%';
    public $fechaDesde, $fechaHasta;
    public $textoBuscar;
    public $categoriaMiembro, $tipoidMiembro, $numeroIDMiembro, $nombreMiembro, $apellidoMiembro, $fechaNacimiento, $sexo, $estadoCivil, $celular, $email, $ciudad, $direccion, $barrio;
    public $edad, $tipoSexo, $tipoMiembro;
    public $tipoPrograma = '%%', $tipoLugarPrograma = '%%', $estadoPrograma = '%%';
    public $datosPrograma;
    public $datosAsistentes;
    public $datosParticipantes;
    protected $paginationTheme = 'bootstrap';
    public $columna = "id", $orden = "asc", $registrosXPagina = 5;



    public function mount()
    {

        $this->totales = [];
        $this->tipoReporte = 0;
        $this->idUsuarioLogueado = auth()->id();
        $this->fechaDesde = Carbon::now()->subMonth(24)->format('Y-m-d');
        $this->fechaHasta = Carbon::now()->format('Y-m-d');
    }
    public function render()
    {
        $data = [];
        $listaCategoria = $this->nombreCategoriaxEdad();
        $listaTipoProgramas = TipoProgramacion::all(['id', 'nombre']);
        $listaLugares = Iglesia::all(['id', 'nombre']);
        $listaUsuarios = User::all(['id', 'name']);
        if ($this->tipoReporte == 1) {
            $data = $this->informePrograma();
        }
        if ($this->tipoReporte == 4) {
            $data = $this->informeMembrecia();
        }

        return view('livewire.reportes.reportes-index', compact(
            'listaCategoria',
            'data',
            'listaTipoProgramas',
            'listaLugares',
            'listaUsuarios'
        ));
    }

    //Generar Reporte Membrecia
    public function informeMembrecia()
    {
        try {
            $edadArray = [];
            if ($this->edad != "") {
                $edadArray = explode('|', $this->edad);
            } else {
                $edadArray[] = 0;
                $edadArray[] = 200;
            }
            $tipoMiembro = [];
            if ($this->tipoMiembro != "") {
                $tipoMiembro = explode('|', $this->tipoMiembro);
            } else {
                $tipoMiembro[] = 0;
                $tipoMiembro[] = 2000;
            }
            $subquery = DB::query()
                ->select('*')->from('membrecias')
                ->where(DB::raw('TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE())'), '>=', $edadArray[0])
                ->where(DB::raw('TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE())'), '<', $edadArray[1])
                ->where(DB::raw('TIMESTAMPDIFF(MONTH,fecha_conversion,CURDATE())'), '>=', $tipoMiembro[0])
                ->where(DB::raw('TIMESTAMPDIFF(MONTH,fecha_conversion,CURDATE())'), '<', $tipoMiembro[1])
                ->where('sexo', 'like', '%' . $this->tipoSexo . '%')
                ->where(function ($query) {
                    $query->where('nombre', 'like', '%' . $this->textoBuscar . '%')
                        ->Orwhere('apellido', 'like', '%' . $this->textoBuscar . '%');
                });
            $data = DB::query()->select(
                "id as idMiembro",
                DB::raw("concat(nombre,' ',apellido) as nombreMIembro"),
                "fecha_nacimiento",
                "fecha_conversion",
                DB::raw('TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) as edad'),
                DB::raw("case when TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >= 0 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) < 5 then 'Bebe'
                       when TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >= 5 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) < 12 then 'Niño(a)'
                       when TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >= 12 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) < 18 then 'Adolescente'
                       when TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >= 18 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) < 25 then 'Joven'
                       when TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >= 25 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) < 40 then 'Joven Adulto'
                       when TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >= 40 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) < 55 then 'Adulto'
                       when TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >= 55 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) < 65 then 'Adulto Mayor'
                       when TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >= 65 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) < 75 then 'Anciano'
                       else 'Longevo' end as categoriaEdad"),
                DB::raw("if(sexo='F','FEMENINO','MASCUNILO') as sexo"),
                DB::raw(" case
                       when estado_civil='c' then 'Casado(a)'
                       when estado_civil='d' then 'Divorciado(a)'
                       when estado_civil='u' then 'UnioLibre'
                       when estado_civil='v' then 'Viudo(a)'
                       else 'Soltero(a)'
                       end as estadoCivil"),
                "celular",
                "email",
                "ciudad",
                "barrio",
                "direccion",
                "fecha_conversion",
                "estado",
                DB::raw(" ifnull((select count(*) from asistencia_programas where id_miembro=idMiembro),0)numeroAsistencias"),
                DB::raw(" ifnull((select nombre from programacions 
                       where id=(select id_programa from asistencia_programas 
                       where id_miembro=idMiembro having(max(created_at)))),'')nombreUltimoPrograma"),
                DB::raw(" ifnull((select fecha from programacions 
                       where id=(select id_programa from asistencia_programas 
                       where id_miembro=idMiembro having(max(created_at)))),'0000-00-00')FechaUltimoPrograma"),
                DB::raw(" ifnull((select nombre from iglesias 
                       where id=(select iglesia_id from programacions
                        where id=(select id_programa from asistencia_programas 
                        where id_miembro=idMiembro having(max(created_at))))),'')nombreUltimoLugar")
            )->fromSub($subquery, 'miembros')->paginate($this->registrosXPagina);

            $this->totales = $this->totalizarXCategoriaEdad($data);
            return $data;
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }

        //$paginacion manual
        // $request = request();
        // $porPagina = 10;
        // $paginaActual = $request->page ?? 1;
        // return $data = new Paginator($data, $porPagina, $paginaActual, [
        //     'path' => $request->url(),
        //     'query' => $request->query()
        // ]);

    }

    //Generar Reporte Programa

    public function informePrograma()
    {
        try {

            $subquery = DB::query()
                ->select('*')->from('programacions')
                // ->where('idPrograma', 'like',  $this->tipoPrograma )
                ->where('tipo_programacion_id', 'like',  $this->tipoPrograma)
                ->where('iglesia_id', 'like', $this->tipoLugarPrograma)
                ->where('estado', 'like',  $this->estadoPrograma)
                ->where('user_id', 'like', $this->idOrganizadorPrograma)
                ->where('nombre', 'like', '%' . $this->textoBuscar . '%')
                ->whereDate('fecha', '>=', $this->fechaDesde)
                ->whereDate('fecha', '<=', $this->fechaHasta);

            $data = DB::query()->select(
                "id as idPrograma",
                DB::raw("ifnull((select nombre from tipo_programacions where id=tipo_programacion_id),'')tipoPrograma"),
                "nombre as nombrePrograma",
                "fecha as fechaPrograma",
                "hora as horaPrograma",
                DB::raw("ifnull((select nombre from iglesias where id=iglesia_id),'')lugar"),
                DB::raw("ifnull((select count(*) from asistencia_programas where id_programa=idPrograma),0)numeroAsistentes"),
                DB::raw("ifnull((select count(*) from asistencia_programas where id_programa=idPrograma and tipo_llegada='Puntual'),0)numeroPuntuales"),
                DB::raw("ifnull((select count(*) from asistencia_programas where id_programa=idPrograma and tipo_llegada='Retrazada'),0)numeroRetrazados"),
                DB::raw("ifnull((select count(*) from asistencia_programas where id_programa=idPrograma and tipo_llegada='Final'),0)numeroLlegaronFinalizando"),
                DB::raw("ifnull((select count(*) from asistencia_programas where id_programa=idPrograma and tipo_miembro='Nuevo'),0)numeroNuevos"),
                DB::raw("ifnull((select count(*) from asistencia_programas where id_programa=idPrograma and tipo_miembro='Antiguo'),0)numeroAnTiguos"),
                DB::raw("ifnull((select name from users where id=user_id),0)usuarioOrganizador"),

            )->fromSub($subquery, "programas")->paginate($this->registrosXPagina);

            return $data;
        } catch (\Throwable $th) {
            report($th);
            return session()->flash('fail', 'Error en Base de datos, contacte al administrador del sistema.');
        }
    }
    //Mostrar Detalle Miembro
    public function verMiembro($idMiembro)
    {
        $miembro = Membrecia::find($idMiembro);
        $this->categoriaMiembro = $this->categorizarXEdad($miembro->fecha_nacimiento->age);
        $this->tipoidMiembro = $miembro->tipo_documento;
        $this->numeroIDMiembro = $miembro->numero_documento;
        $this->nombreMiembro = $miembro->nombre;
        $this->apellidoMiembro = $miembro->apellido;
        $this->fechaNacimiento = $miembro->fecha_nacimiento->toDateString();
        $this->sexo = $miembro->sexo;
        $this->estadoCivil = $miembro->estado_civil;
        $this->celular = $miembro->celular;
        $this->email = $miembro->email;
        $this->ciudad = $miembro->ciudad;
        $this->direccion = $miembro->direccion;
        $this->barrio = $miembro->barrio;
        $this->emit('modal', 'verMiembroModal', 'show');
    }
    //Mostrar Detalle Programa
    public function verPrograma($idPrograma)
    {
        $this->datosPrograma = Programacion::join('tipo_programacions', 'tipo_programacions.id', 'programacions.tipo_programacion_id')
            ->join('iglesias', 'iglesias.id', 'programacions.iglesia_id')
            ->join('users', 'users.id', 'programacions.user_id')
            ->where('programacions.id', $idPrograma)
            ->first([
                'programacions.nombre as nombrePrograma',
                'tipo_programacions.nombre as tipoPrograma',
                'iglesias.nombre as nombreLugar',
                'users.name as nombreOrganizador',
                'fecha',
                'hora'

            ]);

            // dd($this->datosPrograma);
        $this->datosAsistentes = AsistenciaPrograma::join('membrecias', 'membrecias.id', 'asistencia_programas.id_miembro')
            ->where('id_programa', $idPrograma)
            ->select(
                DB::raw('IF (TIMESTAMPDIFF(MONTH,fecha_conversion,CURDATE())<' . $this->mesesMiembroAntiguo() . ',"Nuevo","Antiguo") as tipoMiembro'),
                'membrecias.id as idMiembro',
                'membrecias.nombre as nombreMiembro',
                'membrecias.apellido as apellidoMiembro',
                'membrecias.fecha_conversion as fechaConversion',
                'tipo_llegada as tipoLlegada'
            )
            ->get();

        $this->datosParticipantes = ParticipantesProgramacionMinisterio::join('ministerios', 'ministerios.id', 'participantes_programacion_ministerios.ministerio_id')
            ->join('rols', 'rols.id', 'participantes_programacion_ministerios.rol_id')
            ->join('users', 'users.id', 'participantes_programacion_ministerios.user_id')
            ->where('programacion_id', $idPrograma)
            ->get([
                'users.name as nombreParticipante',
                'rols.nombre as nombreRol',
                'ministerios.nombre as nombreMinisterio'
            ]);

    
        $this->emit('modal', 'verProgramaModal', 'show');
    }
}
