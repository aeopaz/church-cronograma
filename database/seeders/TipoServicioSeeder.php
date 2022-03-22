<?php

namespace Database\Seeders;

use App\Models\TipoServicio;
use Illuminate\Database\Seeder;

class TipoServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoServicio::create([
            'nombre'=>'Juvenil'
        ]);
        TipoServicio::create([
            'nombre'=>'Congregacional'
        ]);
        TipoServicio::create([
            'nombre'=>'Ayuno'
        ]);
        TipoServicio::create([
            'nombre'=>'Alabanza y Adoración'
        ]);
    }
}
