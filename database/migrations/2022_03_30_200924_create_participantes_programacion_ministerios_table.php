<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantesProgramacionMinisteriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participantes_programacion_ministerios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('programacion_id')->default(0);
            $table->unsignedBigInteger('ministerio_id')->default(0);
            $table->unsignedBigInteger('user_id')->default(0);
            $table->unsignedBigInteger('rol_id')->default(0);
            $table->unsignedBigInteger('user_created_id')->default(0);
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
        Schema::dropIfExists('participantes_programacion_ministerios');
    }
}
