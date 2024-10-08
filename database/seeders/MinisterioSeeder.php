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
            'user_id'=>1
        ]);
        //4
        Ministerio::create([
            'nombre'=>'Intersección',
            'iglesia_id'=>1,
            'user_id'=>1
        ]);
        //5
        Ministerio::create([
            'nombre'=>'Finanzas',
            'iglesia_id'=>1,
            'user_id'=>1
        ]);
        //6
        Ministerio::create([
            'nombre'=>'Predicación',
            'iglesia_id'=>1,
            'user_id'=>1
        ]);
        //7
        Ministerio::create([
            'nombre'=>'Infantil',
            'iglesia_id'=>1,
            'user_id'=>1
        ]);
        //8
        Ministerio::create([
            'nombre'=>'Evangelismo',
            'iglesia_id'=>1,
            'user_id'=>1
        ]);
        //9
        Ministerio::create([
            'nombre'=>'Enseñanza y Discipulado',
            'iglesia_id'=>1,
            'user_id'=>1
        ]);
        //10
        Ministerio::create([
            'nombre'=>'Medios Audiovisuales',
            'iglesia_id'=>1,
            'user_id'=>1
        ]);
        //11
        Ministerio::create([
            'nombre'=>'Damas',
            'iglesia_id'=>1,
            'user_id'=>1
        ]);
        //12
        Ministerio::create([
            'nombre'=>'Caballeros',
            'iglesia_id'=>1,
            'user_id'=>1
        ]);
        //13
        Ministerio::create([
            'nombre'=>'Eventos',
            'iglesia_id'=>1,
            'user_id'=>1
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