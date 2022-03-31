<?php

namespace Database\Seeders;

use App\Models\TipoRecurso;
use Illuminate\Database\Seeder;

class TipoRecursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoRecurso::create([
            'nombre'=>'Video',
        ]);
        TipoRecurso::create([
            'nombre'=>'Canción',
        ]);
        TipoRecurso::create([
            'nombre'=>'Documento',
        ]);
    }
}
