<?php

namespace Database\Seeders;

use App\Models\RolMinisterio;
use Illuminate\Database\Seeder;

class RolMinisterioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RolMinisterio::create([
            'nombre'=>'Pianista',
            'id_ministerio'=>1
        ]);
        RolMinisterio::create([
            'nombre'=>'Baterista',
            'id_ministerio'=>1
        ]);
        RolMinisterio::create([
            'nombre'=>'Vocalista',
            'id_ministerio'=>1
        ]);
        RolMinisterio::create([
            'nombre'=>'Corista',
            'id_ministerio'=>1
        ]);
        RolMinisterio::create([
            'nombre'=>'Guitarrista',
            'id_ministerio'=>1
        ]);
        RolMinisterio::create([
            'nombre'=>'Bajista',
            'id_ministerio'=>1
        ]);
        RolMinisterio::create([
            'nombre'=>'Director',
            'id_ministerio'=>1
        ]);
        RolMinisterio::create([
            'nombre'=>'Seguridad',
            'id_ministerio'=>3
        ]);
        RolMinisterio::create([
            'nombre'=>'Limpieza',
            'id_ministerio'=>3
        ]);
        RolMinisterio::create([
            'nombre'=>'Orden',
            'id_ministerio'=>3
        ]);
        RolMinisterio::create([
            'nombre'=>'Intersesor(a)',
            'id_ministerio'=>4
        ]);
        RolMinisterio::create([
            'nombre'=>'Tesorero(a)',
            'id_ministerio'=>5
        ]);
        RolMinisterio::create([
            'nombre'=>'Pastor Principal',
            'id_ministerio'=>6
        ]);
        RolMinisterio::create([
            'nombre'=>'Copastor',
            'id_ministerio'=>6
        ]);
        RolMinisterio::create([
            'nombre'=>'Maestra(o) Infantil',
            'id_ministerio'=>7
        ]);
        RolMinisterio::create([
            'nombre'=>'Evangelista',
            'id_ministerio'=>8
        ]);
       
    }

}
