<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembreciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membrecias', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_documento',3)->default('');
            $table->string('numero_documento',10)->default('');
            $table->string('nombre',60)->default('');
            $table->string('apellido',60)->default('');
            $table->date('fecha_nacimiento',10)->default('2022-06-20');
            $table->string('sexo',1)->default('');
            $table->string('estado_civil',20)->default('');
            $table->string('celular',20)->default('');
            $table->string('email',100)->default('');
            $table->string('ciudad',100)->default('');
            $table->string('barrio',100)->default('');
            $table->string('direccion',100)->default('');
            $table->date('fecha_conversion',10)->default('2022-06-20');
            $table->string('estado',1)->default('A');
            $table->unsignedBigInteger('id_usuario')->default(1);
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
        Schema::dropIfExists('membrecias');
    }
}
