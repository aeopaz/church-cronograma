<?php

namespace Database\Seeders;

use App\Models\Ministerio;
use App\Models\ProgramacionMinisterio;
use App\Models\Recurso;
use App\Models\RecursoProgramacionMinisterio;
use Illuminate\Database\Seeder;

class RecursoProgramacionMinisterioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i <200 ; $i++) { 
            RecursoProgramacionMinisterio::create([
                'programacion_id'=>ProgramacionMinisterio::inRandomOrder()->take(1)->first()->id,
                'ministerio_id'=>Ministerio::inRandomOrder()->take(1)->first()->id,
                'recurso_id'=>Recurso::inRandomOrder()->take(1)->first()->id,
                'user_created_id'=>1
            ]);
        }
      
    }
}
