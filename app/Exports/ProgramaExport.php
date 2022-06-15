<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; //Interactura con el libro
use App\Models\Membrecia;
use App\Models\ParticipantesProgramacionMinisterio;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection; //Trabajar con colecciones y obtener la data
use Maatwebsite\Excel\Concerns\WithHeadings; //Definir encabezados
use Maatwebsite\Excel\Concerns\WithCustomStartCell; //Definir la celda donde inicia el reporte
use Maatwebsite\Excel\Concerns\WithTitle; //Definir nombre a loas hojas del liro
use Maatwebsite\Excel\Concerns\WithStyles; //Definir formato a las celdas



class ProgramaExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithStyles
{

    //Parámetros recibidos
    protected $tipoReporte, $fechaInicial, $fechaFinal, $ministerio;

    function __construct($tipoReporte, $fechaInicial, $fechaFinal, $ministerio)
    {
        $this->tipoReporte = $tipoReporte;
        $this->fechaFinal = $fechaFinal;
        $this->fechaInicial = $fechaInicial;
        $this->ministerio = $ministerio;
    }

    //Data que se mostrará en el archivo
    public function collection()
    {
        $data = [];

        if ($this->tipoReporte == 1) {
            $data = $this->reporteProgramaExcel();
        }
        if ($this->tipoReporte == 2) {
            $data = $this->reporteCronograma();
        }
        if ($this->tipoReporte == 3) {
            $data = $this->reporteCumpleanos();
        }
        if ($this->tipoReporte == 4) {
            $data = $this->reporteMembreciaExcel();
        }
        if ($this->tipoReporte == 5) {
            $data = $this->reporteRecursosExcel();
        }

        return $data;
    }
    public function reporteMembreciaExcel()
    {
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
        )->fromSub($subquery, 'miembros')->get();

        return $data;
    }

    public function reporteProgramaExcel()
    {
        $subquery = DB::query()
            ->select('*')->from('programacions')
            ->whereDate('fecha', '>=', $this->fechaInicial)
            ->whereDate('fecha', '<=', $this->fechaFinal);

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

        )->fromSub($subquery, "programas")->get();

        return $data;
    }

    public function reporteRecursosExcel()
    {
        $subquery = DB::query()
            ->select('*')->from('recursos');
        $data = DB::query()->select(
            "id as idRecurso",
            "nombre",
            "url",
            DB::raw("ifnull((SELECT nombre from tipo_recursos where id=tipo_recurso_id),'')tipoRecurso"),
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
        )->fromSub($subquery, 'recursos')->get();

        return $data;
    }

    public function reporteCronograma()
    {
        $data = ParticipantesProgramacionMinisterio::join('programacions', 'programacions.id', 'programacion_id')
            ->join('users', 'users.id', 'participantes_programacion_ministerios.user_id')
            ->join('ministerios', 'ministerios.id', 'ministerio_id')
            ->join('rols', 'rols.id', 'rol_id')
            ->where('ministerio_id', 'like', $this->ministerio)
            ->whereDate('programacions.fecha', '>=', $this->fechaInicial)
            ->whereDate('programacions.fecha', '<=', $this->fechaFinal)
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->get([
                'programacions.id as idPrograma',
                'programacions.nombre as nombrePrograma',
                'programacions.fecha as fechaPrograma',
                'programacions.hora as horaPrograma',
                'users.name as nombreParticipante',
                'ministerios.nombre as nombreMinisterio',
                'rols.nombre as nombreRol'
            ]);

        return $data;
    }

    public function reporteCumpleanos()
    {
        $data = Membrecia::select(
            'id as idMiembro',
            DB::raw('CONCAT(nombre," ",apellido)'),
            'fecha_nacimiento',
            DB::raw('DAYOFYEAR(fecha_nacimiento) AS diaAnoNacimiento, DAYOFYEAR(curdate()) AS diaAnoActual')
        )
            ->havingRaw('diaAnoNacimiento>=DAYOFYEAR(:fechaDesde) and diaAnoNacimiento<=DAYOFYEAR(:fechaHasta)', ['fechaDesde' => $this->fechaInicial, 'fechaHasta' => $this->fechaFinal])
            ->orderBy('diaAnoNacimiento', 'asc')
            ->get();
        return $data;
    }

    //Títulos columnas
    public function headings(): array
    {
        if ($this->tipoReporte == 1) {
            return ['ID', 'TIPO PROGRAMA', 'NOMBRE', 'FECHA', 'HORA', 'LUGAR', 'ASISTENTES', 'NUEVOS', 'ANTIGUOS', 'PUNTUALES', 'RETRAZADOS', 'LLEGARON FINAL', 'ORGANIZADOR'];
        }
        if ($this->tipoReporte == 2) {
            return ['ID PROGRAMA', 'MINISTERIO', 'PROGRAMA', 'FECHA', 'HORA', 'ENCARGADO', 'FUNCIÓN'];
        }
        if ($this->tipoReporte == 3) {
            return ['ID MIEMBRO',  'NOMBRE', 'CUMPLEAÑOS', 'DÍAS FALTANTES'];
        }
        if ($this->tipoReporte == 4) {
            return ['ID MIEMBRO', 'NOMBRE', 'FECHA NACIMIENTO', 'FECHA CONVERSION', 'EDAD', 'CATEGORIA', 'SEXO', 'ESTADO CIVIL', 'CELULAR', 'EMAIL', 'CIUDAD', 'BARRIO', 'DIRECCION', 'ESTADO', 'NO. ASISTENCIA', 'ÚLTIMO EVENTO ASISTIDO', 'FECHA ULTIMA ASISTENCIA', 'ÚLTIMO LUGAR ASISTIDO'];
        }
        if ($this->tipoReporte == 5) {
            return ['ID RECURSO', 'NOMBRE', 'URL', 'TIPO RECURSO', 'MINISTERIO', 'VECES UTILIZADO', 'ÚLTIMO EVENTO ASISTIDO', 'FECHA ULTIMA ASISTENCIA', 'ÚLTIMO LUGAR ASISTIDO'];
        }
    }
    //Celda en que comienzan los datos
    public function startCell(): string
    {
        return 'A1';
    }
    //Estilos
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
    //Nombre hoja
    public function title(): string
    {
        return 'Reporte';
    }
}
