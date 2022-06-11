<?php

namespace Database\Seeders;

use App\Models\AsistenciaPrograma;
use App\Models\Membrecia;
use Illuminate\Database\Seeder;

class AsistenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoLlegada = ['Puntual', 'Retrazada', 'Final'];
        for ($i = 1; $i < 50; $i++) {
            $miembro=Membrecia::find($i);
            AsistenciaPrograma::create([
                'id_programa' => rand(1, 200),
                'id_miembro' => rand(1, 50),
                'id_usuario' => 1,
                'tipo_llegada' => $tipoLlegada[rand(0, 2)],
                'tipo_miembro'=>$miembro->fecha_conversion->diffInMonths()<3?'Nuevo':'Antiguo'
            ]);
        }
    }
}
