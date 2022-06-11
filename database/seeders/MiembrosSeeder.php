<?php

namespace Database\Seeders;

use App\Models\Membrecia;
use Faker\Factory;
use Illuminate\Database\Seeder;

class MiembrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create('es_VE');
        for ($i = 0; $i < 50; $i++) {
            $miembro = Membrecia::create();
            $miembro->tipo_documento = $faker->randomElement(['CC', 'CE', 'PS', 'TI']);
            $miembro->numero_documento = rand(111111, 9999999999);
            $miembro->nombre = $faker->firstNameFemale();
            $miembro->apellido = $faker->lastName;
            $miembro->fecha_nacimiento = $faker->date('Y-m-d');
            $miembro->fecha_conversion = $faker->date('Y-m-d');
            $miembro->sexo = $faker->randomElement(['F', 'M']);
            $miembro->estado_civil = $faker->randomElement(['S', 'C', 'D', 'U', 'V']);
            $miembro->celular = rand(1111111111, 9999999999);
            $miembro->email = $faker->email();
            $miembro->ciudad = $faker->randomElement(['Cali', 'Jamundi', 'Palmira', 'Candelaria', 'Bogota']);
            $miembro->barrio = $faker->randomElement(['Naranjos', 'Bonanza', 'Marroquin II', 'Alirio Mora', 'Decepaz']);
            $miembro->direccion = $faker->address();
            $miembro->id_usuario = auth()->id();
            $miembro->save();
        }
    }
}
