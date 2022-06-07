<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('es_VE');
        User::create([
            'name' => 'Alvaro Ocampo',
            'email' => 'aeopaz@gmail.com',
            'celular'=>'3207236182',
            'password' => Hash::make(123123),
            'iglesia_id' => 1,
            'tipo_usuario_id' => 1,
        ]);

        for ($i = 0; $i < 100; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => $faker->email(),
                'avatar'=>$faker->imageUrl(),
                'celular'=>rand(1111111111,9999999999),
                'password' => Hash::make(123123),
                'iglesia_id' => 1,
                'tipo_usuario_id' => 2,
            ]);
        }
    }
}
