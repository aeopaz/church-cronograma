<?php

namespace Database\Seeders;

use App\Models\Ministerio;
use App\Models\Recurso;
use App\Models\TipoRecurso;
use Faker\Factory;
use Illuminate\Database\Seeder;

class RecursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i = 0; $i < 100; $i++) {
            Recurso::create([
                'nombre' => TipoRecurso::inRandomOrder()->take(1)->first()->nombre,
                'url' => '',
                'tipo_recurso_id' => TipoRecurso::inRandomOrder()->take(1)->first()->id,
                'ministerio_id' => Ministerio::inRandomOrder()->take(1)->first()->id,
            ]);
        }
    }
}
