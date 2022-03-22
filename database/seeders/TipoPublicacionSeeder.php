<?php

namespace Database\Seeders;

use App\Models\TipoPublicacion;
use Illuminate\Database\Seeder;

class TipoPublicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoPublicacion::create([
            'nombre'=>'Prédica',
        ]);
        TipoPublicacion::create([
            'nombre'=>'Canción',
        ]);
        TipoPublicacion::create([
            'nombre'=>'Enseñanza',
        ]);
    }
}
