<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rol::create([
            'nombre'=>'Pianista',
            
        ]);
        Rol::create([
            'nombre'=>'Baterista',
            
        ]);
        Rol::create([
            'nombre'=>'Vocalista',
            
        ]);
        Rol::create([
            'nombre'=>'Corista',
            
        ]);
        Rol::create([
            'nombre'=>'Guitarrista',
            
        ]);
        Rol::create([
            'nombre'=>'Bajista',
            
        ]);
        Rol::create([
            'nombre'=>'Director Alabanza',
            
        ]);
        Rol::create([
            'nombre'=>'Seguridad',

        ]);
        Rol::create([
            'nombre'=>'Limpieza',

        ]);
        Rol::create([
            'nombre'=>'Orden',

        ]);
        Rol::create([
            'nombre'=>'Intersesor(a)',

        ]);
        Rol::create([
            'nombre'=>'Tesorero(a)',

        ]);
        Rol::create([
            'nombre'=>'Predicador',

        ]);
        Rol::create([
            'nombre'=>'Maestra(o) Infantil',

        ]);
        Rol::create([
            'nombre'=>'Evangelista',

        ]);
       
    }

}
