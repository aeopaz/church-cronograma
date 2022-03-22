<?php

namespace Database\Seeders;

use App\Models\Ministerio;
use Illuminate\Database\Seeder;

class MinisterioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //1
        Ministerio::create([
            'nombre'=>'Alabanza y Adoración',
            'id_iglesia'=>1,
            'id_lider'=>1
        ]);
        //2
        Ministerio::create([
            'nombre'=>'Jóvenes',
            'id_iglesia'=>1,
            'id_lider'=>1
        ]);
        //3
        Ministerio::create([
            'nombre'=>'Servidores',
            'id_iglesia'=>1,
            'id_lider'=>2
        ]);
        //4
        Ministerio::create([
            'nombre'=>'Intersección',
            'id_iglesia'=>1,
            'id_lider'=>3
        ]);
        //5
        Ministerio::create([
            'nombre'=>'Finanzas',
            'id_iglesia'=>1,
            'id_lider'=>4
        ]);
        //6
        Ministerio::create([
            'nombre'=>'Pastoral',
            'id_iglesia'=>1,
            'id_lider'=>5
        ]);
        //7
        Ministerio::create([
            'nombre'=>'Infantil',
            'id_iglesia'=>1,
            'id_lider'=>6
        ]);
        //8
        Ministerio::create([
            'nombre'=>'Evangelismo',
            'id_iglesia'=>1,
            'id_lider'=>7
        ]);
        //9
        Ministerio::create([
            'nombre'=>'Enseñanza y Discipulado',
            'id_iglesia'=>1,
            'id_lider'=>8
        ]);
        //9
        Ministerio::create([
            'nombre'=>'Medios de Comunicación y Audiovizual',
            'id_iglesia'=>1,
            'id_lider'=>1
        ]);
        //10
        Ministerio::create([
            'nombre'=>'Damas',
            'id_iglesia'=>1,
            'id_lider'=>4
        ]);
        //11
        Ministerio::create([
            'nombre'=>'Caballeros',
            'id_iglesia'=>1,
            'id_lider'=>5
        ]);
    }
}
/*
1-ALvaro
2-Flavio
3-Martha
4-CLaudia
5-Arceliano
6-Damariz
7-Felipe
8-Lida



*/