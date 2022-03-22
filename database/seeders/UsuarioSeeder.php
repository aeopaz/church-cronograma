<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            'name'=>'Alvaro Ocampo',
            'email'=>'aeopaz@gmail.com',
            'password'=>Hash::make(12345678),
            'id_iglesia'=>1
        ]);
        User::create([
            'name'=>'Flavio Ocampo',
            'email'=>'flavio@gmail.com',
            'password'=>Hash::make(12345678),
            'id_iglesia'=>1
        ]);
        User::create([
            'name'=>'Martha Paz',
            'email'=>'martha@gmail.com',
            'password'=>Hash::make(12345678),
            'id_iglesia'=>1
        ]);
        User::create([
            'name'=>'Claudia Ordónez',
            'email'=>'claudia@gmail.com',
            'password'=>Hash::make(12345678),
            'id_iglesia'=>1
        ]);
        User::create([
            'name'=>'Arceliano Paz',
            'email'=>'arceliano@gmail.com',
            'password'=>Hash::make(12345678),
            'id_iglesia'=>1
        ]);
        User::create([
            'name'=>'Damrariz Paz',
            'email'=>'damarzi@gmail.com',
            'password'=>Hash::make(12345678),
            'id_iglesia'=>1
        ]);
        User::create([
            'name'=>'Felipe Quesada',
            'email'=>'felipe@gmail.com',
            'password'=>Hash::make(12345678),
            'id_iglesia'=>1
        ]);
        User::create([
            'name'=>'Lida Paz',
            'email'=>'lida@gmail.com',
            'password'=>Hash::make(12345678),
            'id_iglesia'=>1
        ]);
    }
}
