<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNipNivelPrioridadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nip_nivel_prioridads', function (Blueprint $table) {
            $table->id('nip_id');
            $table->string('nip_nombre')->unique();
            $table->string('nip_descripcion');
            $table->integer('nip_estado');
            $table->integer('nip_usu_creacion');
            $table->timestamp('nip_fecha_creacion')->useCurrent();
            $table->integer('nip_usu_modificacion');
            $table->timestamp('nip_fecha_modificacion')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nip_nivel_prioridads');
    }
}
