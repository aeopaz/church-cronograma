<?php

namespace Database\Seeders;

use App\Models\Iglesia;
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
        Iglesia::create([
            'nombre'=>'Iglesia Bautista Jehova Reina',
            'direccion'=>'Carrera 26 G9 No. 73-52',
            'telefono'=>'3207236182',
            'email'=>'ibjehovareina@gmail.com'
        ]);
    }
}
