<?php

namespace Database\Seeders;

use App\Models\Programacion;
use App\Models\TipoProgramacion;
use App\Models\User;
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
        $nivel=['1','2','3'];
        $estado=['A','C'];
        $faker = Factory::create('es_VEN');
        for ($i = 0; $i < 200; $i++) {
            $tipoProgramacion = TipoProgramacion::inRandomOrder()->take(1)->first();
            $user = User::inRandomOrder()->take(1)->first();
            Programacion::create([
                'tipo_programacion_id' => $tipoProgramacion->id,
                'iglesia_id' => 1,
                'nombre' => $tipoProgramacion->nombre,
                'nivel'=>$nivel[rand(0,2)],
                'estado'=>$estado[rand(0,1)],
                'user_id'=>$user->id,
                'fecha' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = '2022-12-31', $timezone = null),
                'hora' => $faker->time('H:i')
            ]);
        }
    }
}
