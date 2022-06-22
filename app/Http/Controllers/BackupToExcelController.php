<?php

namespace App\Http\Controllers;

use App\Exports\BackupExcelExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class BackupToExcelController extends Controller
{
    public function index()
    {
        return view('backup-excel.index');
    }

    public function exportar()
    {
        $fecha=Carbon::now()->format('Y-m-d');
        return Excel::download(new BackupExcelExport, "database-$fecha.xlsx");
    }
}
