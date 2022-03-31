<?php

namespace Database\Seeders;

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
        RecursoProgramacionMinisterio::create([
            'programacion_id'=>ProgramacionMinisterio::inRandomOrder()->take(1)->first()->id,
            'ministerio_id'=>ProgramacionMinisterio::inRandomOrder()->take(1)->first()->id,
            'recurso_id'=>Recurso::inRandomOrder()->take(1)->first()->id,
        ]);
    }
}
