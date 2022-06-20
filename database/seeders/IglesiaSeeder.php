<?php

namespace Database\Seeders;

use App\Models\Iglesia;
use Faker\Factory;
use Illuminate\Database\Seeder;

class IglesiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker=Factory::create('es_VEN');
        Iglesia::create([
            'nombre'=>'Iglesia Bautista Jehova Reina',
            'direccion'=>'Carrera 26 G9 No. 73-52',
            'telefono'=>'3207236182',
            'email'=>'ibjehovareina@gmail.com'
        ]);

        // for ($i=0; $i <100 ; $i++) {
        //     Iglesia::create([
        //         'nombre'=>'Iglesia '.$faker->company(),
        //         'direccion'=>$faker->address(),
        //         'telefono'=>rand(1111111111,9999999999),
        //         'email'=>$faker->email(),
        //     ]);
        // }


    }
}
