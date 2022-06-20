<?php

namespace Database\Seeders;

use App\Models\TipoProgramacion;
use Illuminate\Database\Seeder;

class TipoProgramacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoProgramacion::create([
            'nombre'=>'Dominical Mañana'
        ]);
        TipoProgramacion::create([
            'nombre'=>'Dominical Tarde'
        ]);
        TipoProgramacion::create([
            'nombre'=>'Culto de Oración'
        ]);
        TipoProgramacion::create([
            'nombre'=>'Enseñanza Bíblica'
        ]);
        TipoProgramacion::create([
            'nombre'=>'Celebración Juvenil'
        ]);
        TipoProgramacion::create([
            'nombre'=>'Reunión de Damas'
        ]);
        TipoProgramacion::create([
            'nombre'=>'Reunión de Caballeros'
        ]);
        TipoProgramacion::create([
            'nombre'=>'Ayuno'
        ]);
        TipoProgramacion::create([
            'nombre'=>'Vigilia Media Noche'
        ]);
        TipoProgramacion::create([
            'nombre'=>'Vigilia toda la Noche'
        ]);
        TipoProgramacion::create([
            'nombre'=>'Discipulado'
        ]);
    }
}
