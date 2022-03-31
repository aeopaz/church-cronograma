<?php

namespace Database\Seeders;

use App\Models\Ministerio;
use App\Models\Programacion;
use App\Models\ProgramacionMinisterio;
use Illuminate\Database\Seeder;

class ProgramacionMinisterioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 200; $i++) {
            ProgramacionMinisterio::create([
                'programacion_id' => Programacion::inRandomOrder()->take(1)->first()->id,
                'ministerio_id' => Ministerio::inRandomOrder()->take(1)->first()->id,
            ]);
        }
    }
}
