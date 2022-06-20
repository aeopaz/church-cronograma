<?php

namespace Database\Seeders;

use App\Models\Mensaje;
use App\Models\TipoUsuario;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // $this->call(IglesiaSeeder::class);
        $this->call(TipoUsuarioSeeder::class);
        $this->call(TipoProgramacionSeeder::class);
        $this->call(TipoRecursoSeeder::class);
        $this->call(MinisterioSeeder::class);
        $this->call(RolSeeder::class);
        // $this->call(RecursoSeeder::class);
        $this->call(UsuarioSeeder::class);
        // $this->call(ProgramacionSeeder::class);
        // $this->call(ProgramacionMinisterioSeeder::class);
        // $this->call(ParticipantesProgramacionMinisterioSeeder::class);
        // $this->call(RecursoProgramacionMinisterioSeeder::class);
        // $this->call(MiembrosSeeder::class);
        // $this->call(AsistenciaSeeder::class);
        $this->call(MensajeSeeder::class);

    }
}
