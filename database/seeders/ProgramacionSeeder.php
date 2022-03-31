<?php

namespace Database\Seeders;

use App\Models\Programacion;
use App\Models\TipoProgramacion;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ProgramacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('es_VEN');
        for ($i = 0; $i < 50; $i++) {
            $tipoProgramacion = TipoProgramacion::inRandomOrder()->take(1)->first();
            Programacion::create([
                'tipo_programacion_id' => $tipoProgramacion->id,
                'iglesia_id' => 1,
                'nombre' => $tipoProgramacion->nombre,
                'fecha' => $faker->date($format = 'Y-m-d', $max = '2022-12-31'),
                'hora'=>$faker->time('H:i','now')
            ]);
        }
    }
}
