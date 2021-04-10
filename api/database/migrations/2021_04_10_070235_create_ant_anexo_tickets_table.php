<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntAnexoTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ant_anexo_tickets', function (Blueprint $table) {
            $table->id('ant_id');
            $table->unsignedBigInteger('ant_id_tic')->nullable();
            $table->foreign('ant_id_tic')
                    ->references('tic_id')->on('tic_tickets')
                    ->onDelete('set null');
            $table->string('ant_nombre');
            $table->string('ant_ruta');
            $table->integer('ant_estado');
            $table->integer('ant_usu_creacion');
            $table->timestamp('ant_fecha_creacion')->useCurrent();
            $table->integer('ant_usu_modificacion');
            $table->timestamp('ant_fecha_modificacion')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ant_anexo_tickets');
    }
}
