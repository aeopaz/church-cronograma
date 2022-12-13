<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableModificarProgramacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programacions', function (Blueprint $table) {
            $table->date('fecha_desde')->after('user_id')->default('2022-06-20');
            $table->date('fecha_hasta')->after('fecha_desde')->default('2022-06-20');
        });
        Schema::table('programacions', function (Blueprint $table) {
            $table->dropColumn('fecha');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
