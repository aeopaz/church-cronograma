<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciaProgramasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencia_programas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_programa')->default(1);
            $table->unsignedBigInteger('id_miembro')->default(1);
            $table->unsignedBigInteger('id_usuario')->default(1);
            $table->string('tipo_llegada')->default('');
            $table->string('tipo_miembro')->default('');//Nuevo o Antiguo
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
        Schema::dropIfExists('asistencia_programas');
    }
}
