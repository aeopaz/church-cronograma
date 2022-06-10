<?php

namespace Database\Seeders;

use App\Models\TipoUsuario;
use Illuminate\Database\Seeder;

class TipoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoUsuario::create([
            'nombre'=>'admin',
        ]);
        TipoUsuario::create([
            'nombre'=>'lider',
        ]);
        TipoUsuario::create([
            'nombre'=>'usuario',
        ]);
    }
}
