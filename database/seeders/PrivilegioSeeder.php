<?php

namespace Database\Seeders;

use App\Models\Privilegio;
use Illuminate\Database\Seeder;

class PrivilegioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Privilegio::create([
            'nombre'=>'Predicación',
        ]);
        Privilegio::create([
            'nombre'=>'Enseñanza',
        ]);
        Privilegio::create([
            'nombre'=>'Evangelizar',
        ]);
        Privilegio::create([
            'nombre'=>'Ministrar Alabanza',
        ]);
        Privilegio::create([
            'nombre'=>'Logística y Protocolo',
        ]);
        Privilegio::create([
            'nombre'=>'Medios',
        ]);
    }
}
