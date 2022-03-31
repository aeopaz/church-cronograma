<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecursoProgramacionMinisteriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recurso_programacion_ministerios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('programacion_id')->default(0);
            $table->unsignedBigInteger('ministerio_id')->default(0);
            $table->unsignedBigInteger('recurso_id')->default(0);
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
        Schema::dropIfExists('recurso_programacion_ministerios');
    }
}
