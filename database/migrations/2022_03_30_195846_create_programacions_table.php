<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_programacion_id')->default(0);
            $table->unsignedBigInteger('iglesia_id')->default(0);
            $table->string('nombre',60)->default('');
            $table->unsignedBigInteger('user_id')->default(0);
            $table->date('fecha');
            $table->string('hora');
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
        Schema::dropIfExists('programacions');
    }
}
