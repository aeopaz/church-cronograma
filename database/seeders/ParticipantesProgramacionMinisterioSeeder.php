<?php

namespace Database\Seeders;

use App\Models\Ministerio;
use App\Models\ParticipantesProgramacionMinisterio;
use App\Models\Programacion;
use App\Models\ProgramacionMinisterio;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;

class ParticipantesProgramacionMinisterioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i <200 ; $i++) { 
            ParticipantesProgramacionMinisterio::create([
                'programacion_id'=>Programacion::inRandomOrder()->take(1)->first()->id,
                'ministerio_id'=>Ministerio::inRandomOrder()->take(1)->first()->id,
                'user_id'=>User::inRandomOrder()->take(1)->first()->id,
                'rol_id'=>Rol::inRandomOrder()->take(1)->first()->id,
                'user_created_id'=>1
            ]);
        }
    }
}
