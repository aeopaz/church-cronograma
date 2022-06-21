<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUsuarioMinisterio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_ministerio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->default(1);
            $table->unsignedBigInteger('id_ministerio')->default(1);
            $table->string('estado',1)->default('');
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
        Schema::dropIfExists('usuario_ministerio');
    }
}
