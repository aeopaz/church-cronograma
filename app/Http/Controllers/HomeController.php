<?php

namespace App\Http\Controllers;

use App\Models\Membrecia;
use App\Models\Mensaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       $cumpleaneros = Membrecia::select(
            'id as idMiembro',
            'nombre',
            'apellido',
            'fecha_nacimiento',
            DB::raw('DAYOFYEAR(fecha_nacimiento) AS diaAnoNacimiento, DAYOFYEAR(curdate()) AS diaAnoActual')
        )->WhereRaw("DAYOFYEAR(curdate()) <= DAYOFYEAR(fecha_nacimiento) AND DAYOFYEAR(curdate()) + ? >=  dayofyear(fecha_nacimiento)",[7] )->OrderBy(DB::raw("DAYOFYEAR(fecha_nacimiento)"),"ASC")->get();
        $mensaje = Mensaje::all()->random(1)->first(); //Toma un mensaje aleatorio
        return view('home', compact('mensaje','cumpleaneros'));
    }
}
