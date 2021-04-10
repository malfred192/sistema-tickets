<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolRolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rol_rols', function (Blueprint $table) {
            $table->id('rol_id');
            $table->string('rol_nombre')->unique();
            $table->integer('rol_estado');
            $table->integer('rol_usu_creacion');
            $table->timestamp('rol_fecha_creacion')->useCurrent();
            $table->integer('rol_usu_modificacion');
            $table->timestamp('rol_fecha_modificacion')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rol_rols');
    }
}
