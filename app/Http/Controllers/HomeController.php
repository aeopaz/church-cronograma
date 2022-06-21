<?php

namespace App\Http\Controllers;

use App\Models\Membrecia;
use App\Models\Mensaje;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
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
        $fechaActual = Carbon::now();
        $fechaDesde = $fechaActual->subDays($fechaActual->format('j') - 1);
        $cumpleaneros = $data = Membrecia::select(
            'id as idMiembro',
            'nombre',
            'apellido',
            'fecha_nacimiento',
            //DB::raw('DAYOFYEAR(fecha_nacimiento) AS diaAnoNacimiento, DAYOFYEAR(curdate()) AS diaAnoActual')//en mysql
            DB::raw('EXTRACT(doy FROM fecha_nacimiento) AS diaAnoNacimiento, EXTRACT(doy FROM CURRENT_DATE) AS diaAnoActual')
        )
            //->havingRaw('diaAnoNacimiento>=DAYOFYEAR(:fechaDesde) and diaAnoNacimiento<=DAYOFYEAR(:fechaHasta)', ['fechaDesde' => $fechaDesde->format('Y-m-d'), 'fechaHasta' => $fechaDesde->addMonth(1)->format('Y-m-d')])->get();//Mysl
            ->groupBy('id')
            ->havingRaw("EXTRACT(doy FROM fecha_nacimiento)>=EXTRACT(doy FROM to_date('".$fechaDesde->format('Ymd')."','YYYYMMDD')) and EXTRACT(doy FROM fecha_nacimiento)<=EXTRACT(doy FROM to_date('".$fechaDesde->addMonth(1)->format('Ymd')."','YYYYMMDD')) ")->get();//Postgres
            // dd($cumpleaneros);
        $mensajesBiblicos = Mensaje::all()->random(1)->first(); //Toma un mensaje aleatorio
        $notificaciones = Auth::user()->unreadNotifications;
        return view('home', compact('mensajesBiblicos', 'cumpleaneros', 'notificaciones'));
    }

    //Marcar notificaciones como leidas
    public function marcarNotificacionLeida($idNotification)
    {
        try {
            $notification = auth()->user()->notifications->where('id', $idNotification)->first();
            $notification->markAsRead();

            return back();
        } catch (\Throwable $th) {
            report($th);
            return back()->with('fail','Error al marcar como leida la notificación, contacte al administrador del sistema');
        }
    }
}
