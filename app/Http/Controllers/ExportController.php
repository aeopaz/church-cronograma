<?php

namespace App\Http\Controllers;

use App\Exports\ExportarExcel;
use App\Models\AsistenciaPrograma;
use App\Models\Membrecia;
use App\Models\ParticipantesProgramacionMinisterio;
use App\Models\Programacion;
use App\Models\Recurso;
use App\Traits\FuncionesTrait;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    use FuncionesTrait;
    public function reportePdf($tipoReporte, $fechaInicial = null, $fechaFinal = null, $ministerio)
    {
        if ($tipoReporte == 1) {
            $data = $this->reporteProgramaPdf($fechaInicial, $fechaFinal);
            $pdf = PDF::loadView('reportes.programa-pdf', compact('data', 'fechaInicial', 'fechaFinal'))->setPaper('a4', 'landscape');
        }
        if ($tipoReporte == 2) {
            $data = $this->reporteCronograma($fechaInicial, $fechaFinal, $ministerio);
            $pdf = PDF::loadView('reportes.cronograma-pdf', compact('data', 'fechaInicial', 'fechaFinal'))->setPaper('a4', 'landscape');
        }
        if ($tipoReporte == 3) {
            $data = $this->reporteCumpleanos($fechaInicial, $fechaFinal, $ministerio);
            $pdf = PDF::loadView('reportes.cumpleaneros-pdf', compact('data', 'fechaInicial', 'fechaFinal'));
        }
        if ($tipoReporte == 4) {
            $data = $this->reporteMembreciaPdf();
            $pdf = PDF::loadView('reportes.membrecia-pdf', compact('data', 'fechaInicial', 'fechaFinal'))->setPaper('a4', 'landscape');
        }
        if ($tipoReporte == 5) {
            $data = $this->reporteRecursosPdf();
            $pdf = PDF::loadView('reportes.recurso-pdf', compact('data', 'fechaInicial', 'fechaFinal'))->setPaper('a4', 'landscape');
        }

        return $pdf->stream();
    }

    public function reporteMembreciaPdf()
    {
        //Mysql
        /*
        $subquery = DB::query()
            ->select('*')->from('membrecias');
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
        )->fromSub($subquery, 'miembros')->get();*/
        $data = Membrecia::select(
            "id as idMiembro",
            'nombre',
            'apellido',
            'sexo as idSexo',
            DB::raw("concat(nombre,' ',apellido) as nombreMiembro"),
            "fecha_nacimiento",
            "fecha_conversion",
            DB::raw('EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) as edad'),
            DB::raw("case when EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) >= 0 and EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) < 5 then 'Bebe' when EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) >= 5 and EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) < 12 then 'Niño(a)' when EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) >= 12 and EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) < 18 then 'Adolescente' when EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) >= 18 and EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) < 25 then 'Joven' when EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) >= 25 and EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) < 40 then 'Joven Adulto' when EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) >= 40 and EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) < 55 then 'Adulto' when EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) >= 55 and EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) < 65 then 'Adulto Mayor' when EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) >= 65 and EXTRACT(YEAR from current_date)-EXTRACT(YEAR from fecha_nacimiento) < 75 then 'Anciano' else 'Longevo' end as categoriaEdad"),
            DB::raw("case when sexo='F' then 'FEMENINO' else 'MASCUNILO' end as sexo"),
            DB::raw("case when estado_civil='c' then 'Casado(a)' when estado_civil='d' then 'Divorciado(a)' when estado_civil='u' then 'UnioLibre' when estado_civil='v' then 'Viudo(a)' else 'Soltero(a)' end as estadoCivil"),
            "celular",
            "email",
            "ciudad",
            "barrio",
            "direccion",
            "fecha_conversion",
            "estado",
            DB::raw("(select count(*) from asistencia_programas where id_miembro=membrecias.id) as numeroAsistencias"),
            DB::raw("(select nombre as nombreultimoprograma from programacions where id=(select id_programa from asistencia_programas where id_miembro=membrecias.id order by created_at desc limit 1))"),
            DB::raw("(select fecha_desde as fechaultimoprograma from programacions where id=(select id_programa from asistencia_programas where id_miembro=membrecias.id order by created_at desc limit 1))"),
            DB::raw("(select nombre as nombreultimolugar from iglesias where id=(select iglesia_id from programacions where id=(select id_programa from asistencia_programas where id_miembro=membrecias.id order by created_at desc limit 1)))"),
        )->get();

        return $data;
    }

    public function reporteProgramaPdf($fechaInicial, $fechaFinal)
    {
        //Mysql
        /*
        $subquery = DB::query()
            ->select('*')->from('programacions')
            ->whereDate('fecha', '>=', $fechaInicial)
            ->whereDate('fecha', '<=', $fechaFinal);

        $data = DB::query()->select(
            "id as idPrograma",
            DB::raw("ifnull((select nombre from tipo_programacions where id=tipo_programacion_id),'')tipoPrograma"),
            "nombre as nombrePrograma",
            "fecha as fechaPrograma",
            "hora as horaPrograma",
            DB::raw("ifnull((select nombre from iglesias where id=iglesia_id),'')lugar"),
            DB::raw("ifnull((select count(*) from asistencia_programas where id_programa=idPrograma),0)numeroAsistentes"),
            DB::raw("ifnull((select count(*) from asistencia_programas where id_programa=idPrograma and tipo_llegada='Puntual'),0)numeroPuntuales"),
            DB::raw("ifnull((select count(*) from asistencia_programas where id_programa=idPrograma and tipo_llegada='Retrasada'),0)numeroRetrasados"),
            DB::raw("ifnull((select count(*) from asistencia_programas where id_programa=idPrograma and tipo_llegada='Final'),0)numeroLlegaronFinalizando"),
            DB::raw("ifnull((select count(*) from asistencia_programas where id_programa=idPrograma and tipo_miembro='Nuevo'),0)numeroNuevos"),
            DB::raw("ifnull((select count(*) from asistencia_programas where id_programa=idPrograma and tipo_miembro='Antiguo'),0)numeroAnTiguos"),
            DB::raw("ifnull((select name from users where id=user_id),0)usuarioOrganizador"),

        )->fromSub($subquery, "programas")->get();*/
        //Postgres
        $data = Programacion::select(
            "id as idPrograma",
            DB::raw("(select nombre from tipo_programacions where id=tipo_programacion_id) as tipoPrograma"),
            "nombre as nombrePrograma",
            "fecha_desde as fechaPrograma",
            "hora as horaPrograma",
            DB::raw("(select nombre from iglesias where id=iglesia_id) as lugar"),
            DB::raw("(select count(*) from asistencia_programas where id_programa=programacions.id) as numeroAsistentes"),
            DB::raw("(select count(*) from asistencia_programas where id_programa=programacions.id and tipo_llegada='Puntual') as numeroPuntuales"),
            DB::raw("(select count(*) from asistencia_programas where id_programa=programacions.id and tipo_llegada='Retrasada') as numeroRetrasados"),
            DB::raw("(select count(*) from asistencia_programas where id_programa=programacions.id and tipo_llegada='Final') as numeroLlegaronFinalizando"),
            DB::raw("(select count(*) from asistencia_programas where id_programa=programacions.id and tipo_miembro='Nuevo') as numeroNuevos"),
            DB::raw("(select count(*) from asistencia_programas where id_programa=programacions.id and tipo_miembro='Antiguo') as numeroAnTiguos"),
            DB::raw("(select name from users where id=user_id) as usuarioOrganizador")
        )
            // ->where('idPrograma', 'like',  $this->tipoPrograma )
            // ->where('tipo_programacion_id', 'like',  $this->tipoPrograma)
            // ->where('iglesia_id', 'like', $this->tipoLugarPrograma)
            // ->where('estado', 'like',  $this->estadoPrograma)
            // ->where('user_id', 'like', $this->idOrganizadorPrograma)
            // ->where('nombre', 'like', '%' . $this->textoBuscar . '%')
            ->whereDate('fecha_desde', '>=', $fechaInicial)
            ->whereDate('fecha_desde', '<=', $fechaFinal)->get();


        return $data;
    }

    public function reporteRecursosPdf()
    {
        //Mysql
        /*
        $subquery = DB::query()
            ->select('*')->from('recursos');
        $data = DB::query()->select(
            "id as idRecurso",
            "nombre",
            "url",
            "tipo_recurso_id",
            DB::raw("ifnull((SELECT nombre from tipo_recursos where id=tipo_recurso_id),'')tipoRecurso"),
            "ministerio_id",
            DB::raw("ifnull((SELECT nombre from ministerios where id=ministerio_id),'')ministerio"),
            DB::raw(" ifnull((select count(*) from recurso_programacion_ministerios where recurso_id=idRecurso),0)vecesUtilizado"),

            DB::raw(" ifnull((select nombre from programacions 
                    where id=(select programacion_id from recurso_programacion_ministerios 
                    where recurso_id=idRecurso having(max(created_at)))),'')nombreUltimoPrograma"),
            DB::raw(" ifnull((select fecha from programacions 
                    where id=(select programacion_id from recurso_programacion_ministerios 
                    where recurso_id=idRecurso having(max(created_at)))),'0000-00-00')FechaUltimoPrograma"),
            DB::raw(" ifnull((select nombre from iglesias 
                    where id=(select iglesia_id from programacions
                    where id=(select programacion_id from recurso_programacion_ministerios 
                    where recurso_id=idRecurso having(max(created_at))))),'')nombreUltimoLugar")
        )->fromSub($subquery, 'recursos')->get();*/
        //Postgres
        $data = Recurso::select(
            "id as idRecurso",
            "nombre",
            "url",
            "tipo_recurso_id",
            DB::raw("(SELECT nombre from tipo_recursos where id=tipo_recurso_id) as tipoRecurso"),
            "ministerio_id",
            DB::raw("(SELECT nombre from ministerios where id=ministerio_id) as ministerio"),
            DB::raw("(select count(*) from recurso_programacion_ministerios where recurso_id=recursos.id) as vecesUtilizado"),
            DB::raw("(select nombre from programacions 
                        where id=(select programacion_id from recurso_programacion_ministerios 
                        where recurso_id=recursos.id order by created_at desc limit 1)) as nombreUltimoPrograma"),
            DB::raw("(select fecha_desde from programacions 
                        where id=(select programacion_id from recurso_programacion_ministerios 
                        where recurso_id=recursos.id order by created_at desc limit 1)) as FechaUltimoPrograma"),
            DB::raw("(select nombre from iglesias 
                        where id=(select iglesia_id from programacions
                        where id=(select programacion_id from recurso_programacion_ministerios 
                        where recurso_id=recursos.id order by created_at desc limit 1))) as nombreUltimoLugar")
        )->get();

        return $data;
    }

    public function reporteCronograma($fechaInicial, $fechaFinal, $ministerio)
    {
        $data = ParticipantesProgramacionMinisterio::join('programacions', 'programacions.id', 'programacion_id')
            ->join('users', 'users.id', 'participantes_programacion_ministerios.user_id')
            ->join('ministerios', 'ministerios.id', 'ministerio_id')
            ->join('rols', 'rols.id', 'rol_id')
            ->where('ministerio_id', 'like', $ministerio)
            ->whereDate('programacions.fecha_desde', '>=', $fechaInicial)
            ->whereDate('programacions.fecha_desde', '<=', $fechaFinal)
            ->orderBy('fecha_desde', 'asc')
            ->orderBy('hora', 'asc')
            ->get([
                'programacions.id as idPrograma',
                'programacions.nombre as nombrePrograma',
                'programacions.fecha_desde as fechaPrograma',
                'programacions.hora as horaPrograma',
                'users.name as nombreParticipante',
                'ministerios.nombre as nombreMinisterio',
                'rols.nombre as nombreRol'
            ]);

        return $data;
    }

    public function reporteCumpleanos($fechaInicial, $fechaFinal)
    {
        //Mysql
        /*
        $data = Membrecia::select(
            'id as idMiembro',
            'nombre',
            'apellido',
            'fecha_nacimiento',
            DB::raw('DAYOFYEAR(fecha_nacimiento) AS diaAnoNacimiento, DAYOFYEAR(curdate()) AS diaAnoActual')
        )
            ->havingRaw('diaAnoNacimiento>=DAYOFYEAR(:fechaDesde) and diaAnoNacimiento<=DAYOFYEAR(:fechaHasta)', ['fechaDesde' => $fechaInicial, 'fechaHasta' => $fechaFinal])
            ->orderBy('diaAnoNacimiento', 'asc')
            ->get();*/

        //Postgres
        $data = Membrecia::select(
            'id as idMiembro',
            'nombre',
            'apellido',
            'fecha_nacimiento',
            DB::raw('EXTRACT(doy FROM fecha_nacimiento) AS diaAnoNacimiento, EXTRACT(doy FROM CURRENT_DATE) AS diaAnoActual')
        )
            // ->Orwhere('nombre', 'like', '%' . $this->textoBuscar . '%')
            // ->Orwhere('apellido', 'like', '%' . $this->textoBuscar . '%')
            ->havingRaw("EXTRACT(doy FROM fecha_nacimiento)>=EXTRACT(doy FROM to_date('" . Carbon::parse($fechaInicial)->format('Ymd') . "','YYYYMMDD')) and EXTRACT(doy FROM fecha_nacimiento)<=EXTRACT(doy FROM to_date('" . Carbon::parse($fechaFinal)->format('Ymd') . "','YYYYMMDD'))")
            ->orderBy('diaanonacimiento', 'asc')
            ->groupBy('id')
            ->get();
        return $data;
    }

    public function reporteExcel($tipoReporte, $fechaInicial = null, $fechaFinal = null, $ministerio)
    {

        $nombreReporte = 'Reporte.xlsx';
        return Excel::download(new ExportarExcel($tipoReporte, $fechaInicial, $fechaFinal, $ministerio), $nombreReporte);
    }

    public function reportePdfPrograma($idPrograma, $fechaInicial, $fechaFinal)
    {
        //Datos Programa
       //Postgress. Para Mysql, ver el informe de todos los prgramas
        $datosPrograma = Programacion::select(
            "id as idPrograma",
            DB::raw("(select nombre from tipo_programacions where id=tipo_programacion_id) as tipoPrograma"),
            //DB::raw("ifnull((select nombre from tipo_programacions where id=tipo_programacion_id),'')tipoPrograma"),
            "nombre as nombrePrograma",
            "fecha_desde",
            "hora",
            "user_id",
            DB::raw("(select nombre from iglesias where id=iglesia_id) as lugar"),
            DB::raw("(select count(*) from asistencia_programas where id_programa=programacions.id) as numeroAsistentes"),
            DB::raw("(select count(*) from asistencia_programas where id_programa=programacions.id and tipo_llegada='Puntual') as numeroPuntuales"),
            DB::raw("(select count(*) from asistencia_programas where id_programa=programacions.id and tipo_llegada='Retrasada') as numeroRetrasados"),
            DB::raw("(select count(*) from asistencia_programas where id_programa=programacions.id and tipo_llegada='Final') as numeroLlegaronFinalizando"),
            DB::raw("(select count(*) from asistencia_programas where id_programa=programacions.id and tipo_miembro='Nuevo') as numeroNuevos"),
            DB::raw("(select count(*) from asistencia_programas where id_programa=programacions.id and tipo_miembro='Antiguo') as numeroAnTiguos"),
            DB::raw("(select name from users where id=user_id) as usuarioOrganizador")

        )->where('id', 'like',  $idPrograma)->first();

        $datosAsistentes = AsistenciaPrograma::join('membrecias', 'membrecias.id', 'asistencia_programas.id_miembro')
            ->where('id_programa', $idPrograma)
            ->select(
                //DB::raw('IF (TIMESTAMPDIFF(MONTH,fecha_conversion,CURDATE())<' . $this->mesesMiembroAntiguo() . ',"Nuevo","Antiguo") as tipoMiembro'),
                'membrecias.id as idMiembro',
                'membrecias.nombre as nombreMiembro',
                'membrecias.apellido as apellidoMiembro',
                'membrecias.fecha_conversion as fechaConversion',
                'tipo_llegada as tipoLlegada'
            )
            ->get();

        $datosParticipantes = ParticipantesProgramacionMinisterio::join('ministerios', 'ministerios.id', 'participantes_programacion_ministerios.ministerio_id')
            ->join('rols', 'rols.id', 'participantes_programacion_ministerios.rol_id')
            ->join('users', 'users.id', 'participantes_programacion_ministerios.user_id')
            ->where('programacion_id', $idPrograma)
            ->get([
                'users.name as nombreParticipante',
                'rols.nombre as nombreRol',
                'ministerios.nombre as nombreMinisterio'
            ]);

        $pdf = PDF::loadView('reportes.detalle-programa-pdf', compact('datosPrograma', 'datosAsistentes', 'datosParticipantes', 'fechaInicial', 'fechaFinal'));
        return $pdf->stream();
    }
}
