<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstEstadoTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('est_estado_tickets', function (Blueprint $table) {
            $table->id('est_id');
            $table->string('est_nombre')->unique();
            $table->mediumText('est_descripcion');
            $table->integer('est_estado');
            $table->integer('est_usu_creacion');
            $table->timestamp('est_fecha_creacion')->useCurrent();
            $table->integer('est_usu_modificacion');
            $table->timestamp('est_fecha_modificacion')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('est_estado_tickets');
    }
}
