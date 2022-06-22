<?php

namespace App\Exports;

use App\Exports\Sheets\TableDataBase;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BackupExcelExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new TableDataBase('users');
        $sheets[] = new TableDataBase('asistencia_programas');
        $sheets[] = new TableDataBase('membrecias');
        $sheets[] = new TableDataBase('mensajes');
        $sheets[] = new TableDataBase('ministerios');
        $sheets[] = new TableDataBase('notifications');
        $sheets[] = new TableDataBase('participantes_programacion_ministerios');
        $sheets[] = new TableDataBase('programacion_ministerios');
        $sheets[] = new TableDataBase('programacions');
        $sheets[] = new TableDataBase('recurso_programacion_ministerios');
        $sheets[] = new TableDataBase('recursos');
        $sheets[] = new TableDataBase('rols');
        $sheets[] = new TableDataBase('tipo_programacions');
        $sheets[] = new TableDataBase('tipo_recursos');
        $sheets[] = new TableDataBase('tipo_usuarios');
        $sheets[] = new TableDataBase('usuario_ministerio');

        return $sheets;
    }
}
