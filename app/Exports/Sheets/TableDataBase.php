<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection; //Trabajar con colecciones y obtener la data

class TableDataBase implements WithTitle,FromCollection
{
    private $nombreTabla;

    public function __construct($nombreTabla)
    {
        $this->nombreTabla = $nombreTabla;
    }

    public function collection()
    {
        return DB::query()->select('*')->from($this->nombreTabla)->get();
    }

    public function title():string
    {
        return $this->nombreTabla;
    }
}
