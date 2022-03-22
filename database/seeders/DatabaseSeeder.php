<?php

namespace Database\Seeders;

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
        $this->call(IglesiaSeeder::class);
        $this->call(UsuarioSeeder::class);
        $this->call(MinisterioSeeder::class);
        $this->call(RolMinisterioSeeder::class);
        $this->call(TipoPublicacionSeeder::class);
        $this->call(TipoServicioSeeder::class);
        $this->call(PrivilegioSeeder::class);

    }
}
