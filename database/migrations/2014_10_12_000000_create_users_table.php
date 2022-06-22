<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('');
            $table->string('email')->unique()->default('');
            $table->string('celular',10)->default('');
            $table->string('avatar')->default('');
            $table->smallInteger('tipo_usuario_id')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default('');
            $table->integer('iglesia_id')->nullable();
            $table->string('estado',1)->default('I');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
