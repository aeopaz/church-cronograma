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
            'iglesia_id'=>1,
            'user_id'=>1
        ]);
        //2
        Ministerio::create([
            'nombre'=>'Jóvenes',
            'iglesia_id'=>1,
            'user_id'=>1
        ]);
        //3
        Ministerio::create([
            'nombre'=>'Servidores',
            'iglesia_id'=>1,
            'user_id'=>2
        ]);
        //4
        Ministerio::create([
            'nombre'=>'Intersección',
            'iglesia_id'=>1,
            'user_id'=>3
        ]);
        //5
        Ministerio::create([
            'nombre'=>'Finanzas',
            'iglesia_id'=>1,
            'user_id'=>4
        ]);
        //6
        Ministerio::create([
            'nombre'=>'Pastoral',
            'iglesia_id'=>1,
            'user_id'=>5
        ]);
        //7
        Ministerio::create([
            'nombre'=>'Infantil',
            'iglesia_id'=>1,
            'user_id'=>6
        ]);
        //8
        Ministerio::create([
            'nombre'=>'Evangelismo',
            'iglesia_id'=>1,
            'user_id'=>7
        ]);
        //9
        Ministerio::create([
            'nombre'=>'Enseñanza y Discipulado',
            'iglesia_id'=>1,
            'user_id'=>8
        ]);
        //9
        Ministerio::create([
            'nombre'=>'Medios de Comunicación y Audiovizual',
            'iglesia_id'=>1,
            'user_id'=>1
        ]);
        //10
        Ministerio::create([
            'nombre'=>'Damas',
            'iglesia_id'=>1,
            'user_id'=>4
        ]);
        //11
        Ministerio::create([
            'nombre'=>'Caballeros',
            'iglesia_id'=>1,
            'user_id'=>5
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