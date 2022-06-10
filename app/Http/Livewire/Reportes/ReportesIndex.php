<?php

namespace App\Http\Livewire\Reportes;

use App\Models\Membrecia;
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
    public $idUsuario;
    public $fechaDesde, $fechaHasta;
    public $textoBuscar;
    public $categoriaMiembro, $tipoidMiembro, $numeroIDMiembro, $nombreMiembro, $apellidoMiembro, $fechaNacimiento, $sexo, $estadoCivil, $celular, $email, $ciudad, $direccion, $barrio;
    public $edad, $tipoSexo;
    protected $paginationTheme = 'bootstrap';
    public $columna="id", $orden="asc",$registrosXPagina=5;



    public function mount()
    {

        $this->totales = [];
        $this->tipoReporte = 0;
        $this->idUsuario = auth()->id();
        $this->fechaDesde = Carbon::now()->format('Y-m-d');
        $this->fechaHasta = Carbon::now()->format('Y-m-d');
    }
    public function render()
    {
        $listaCategoria = $this->nombreCategoriaxEdad();
        $data = $this->informeAsistencia();
        return view('livewire.reportes.reportes-index', compact('listaCategoria', 'data'));
    }

    public function informeAsistencia()
    {
        $edadArray = [];

        if ($this->tipoReporte == 4) {
            if ($this->edad != "") {
                $edadArray = explode('|', $this->edad);
            } else {
                $edadArray[] = 0;
                $edadArray[] = 200;
            }
            // $cantidadRegistros = DB::select(
            //     "SELECT count(*) as cantidad

            //     from (select * from membrecias 
            //                 where (nombre like :nombreBuscar1 or apellido like :nombreBuscar2)
            //                 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >=:edadInicial and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) <:edadFinal and sexo like :tipoSexo ) as miembros;",
            //     [
            //         'nombreBuscar1' => '%' . $this->textoBuscar . '%',
            //         'nombreBuscar2' => '%' . $this->textoBuscar . '%',
            //         'edadInicial' => $edadArray[0],
            //         'edadFinal' => $edadArray[1],
            //         'tipoSexo' => '%' . $this->tipoSexo . '%',
            //     ]
            // );
            // $data = DB::select(
            //     "SELECT
            //     id as idMiembro,
            //     concat(nombre,' ',apellido) as nombreMIembro,
            //     fecha_nacimiento,
            //     TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) as edad,
            //     case
            //     when TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >= 0 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) < 5 then 'Bebe'
            //     when TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >= 5 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) < 12 then 'Niño(a)'
            //     when TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >= 12 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) < 18 then 'Adolescente'
            //     when TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >= 18 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) < 25 then 'Joven'
            //     when TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >= 25 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) < 40 then 'Joven Adulto'
            //     when TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >= 40 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) < 55 then 'Adulto'
            //     when TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >= 55 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) < 65 then 'Adulto Mayor'
            //     when TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >= 65 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) < 75 then 'Anciano'
            //     else 'Longevo'
            //     end as categoriaEdad,
            //     if(sexo='F','FEMENINO','MASCUNILO') as sexo,
            //     case
            //     when estado_civil='c' then 'Casado(a)'
            //     when estado_civil='d' then 'Divorciado(a)'
            //     when estado_civil='u' then 'UnioLibre'
            //     when estado_civil='v' then 'Viudo(a)'
            //     else 'Soltero(a)'
            //     end as estadoCivil,
            //     celular,
            //     email,
            //     ciudad,
            //     barrio,
            //     direccion,
            //     fecha_conversion,
            //     estado,
            //     ifnull((select count(*) from asistencia_programas where id_miembro=idMiembro),0)numeroAsistencias,
            //     ifnull((select nombre from programacions 
            //                     where id=(select id_programa from asistencia_programas 
            //                     where id_miembro=idMiembro having(max(created_at)))),0)nombreUltimoPrograma,
            //     ifnull((select fecha from programacions 
            //                     where id=(select id_programa from asistencia_programas 
            //                     where id_miembro=idMiembro having(max(created_at)))),'0000-00-00')FechaUltimoPrograma,
            //     ifnull((select nombre from iglesias 
            //                     where id=(select iglesia_id from programacions
            //                                     where id=(select id_programa from asistencia_programas 
            //                                                     where id_miembro=idMiembro having(max(created_at))))),'0000-00-00')nombreUltimoLugar
            //     from (select * from membrecias 
            //                 where (nombre like :nombreBuscar1 or apellido like :nombreBuscar2)
            //                 and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) >=:edadInicial and TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE()) <:edadFinal and sexo like :tipoSexo ) as miembros;",
            //     [
            //         'nombreBuscar1' => '%' . $this->textoBuscar . '%',
            //         'nombreBuscar2' => '%' . $this->textoBuscar . '%',
            //         'edadInicial' => $edadArray[0],
            //         'edadFinal' => $edadArray[1],
            //         'tipoSexo' => '%' . $this->tipoSexo . '%',
            //     ]
            // );

            $subquery = DB::query()
                ->select('*')->from('membrecias')
                ->where(DB::raw('TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE())'), '>=', $edadArray[0])
                ->where(DB::raw('TIMESTAMPDIFF(YEAR,fecha_nacimiento,CURDATE())'), '<', $edadArray[1])
                ->where('sexo','like', '%'.$this->tipoSexo.'%')
                ->where(function ($query) {
                    $query->where('nombre','like', '%' . $this->textoBuscar . '%')
                        ->Orwhere('apellido','like', '%' . $this->textoBuscar . '%');
                });
            $data = DB::query()->select(
                "id as idMiembro",
                DB::raw("concat(nombre,' ',apellido) as nombreMIembro"),
                "fecha_nacimiento",
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
                   where id_miembro=idMiembro having(max(created_at)))),0)nombreUltimoPrograma"),
                DB::raw(" ifnull((select fecha from programacions 
                   where id=(select id_programa from asistencia_programas 
                   where id_miembro=idMiembro having(max(created_at)))),'0000-00-00')FechaUltimoPrograma"),
                DB::raw(" ifnull((select nombre from iglesias 
                   where id=(select iglesia_id from programacions
                    where id=(select id_programa from asistencia_programas 
                    where id_miembro=idMiembro having(max(created_at))))),'0000-00-00')nombreUltimoLugar")
            )->fromSub($subquery, 'miembros')->paginate($this->registrosXPagina);
            // dd($data);

            $this->totales = $this->totalizarXCategoriaEdad($data);
            return $data;
            //$paginacion manual
            // $request = request();
            // $porPagina = 10;
            // $paginaActual = $request->page ?? 1;
            // return $data = new Paginator($data, $porPagina, $paginaActual, [
            //     'path' => $request->url(),
            //     'query' => $request->query()
            // ]);
        }
    }
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
}
