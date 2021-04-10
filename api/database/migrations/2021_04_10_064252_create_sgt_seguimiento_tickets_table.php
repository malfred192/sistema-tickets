<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSgtSeguimientoTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sgt_seguimiento_tickets', function (Blueprint $table) {
            $table->id('sgt_id');
            $table->unsignedBigInteger('sgt_id_tic')->nullable();
            $table->foreign('sgt_id_tic')
                    ->references('tic_id')->on('tic_tickets')
                    ->onDelete('set null');
            $table->unsignedBigInteger('sgt_id_esc')->nullable();
            $table->foreign('sgt_id_esc')
                    ->references('est_id')->on('est_estado_tickets')
                    ->onDelete('set null');
            $table->timestamp('sgt_fecha_seguimiento')->useCurrent();
            $table->timestamp('sgt_fecha_registro')->useCurrent();
            $table->string('sgt_responsable');
            $table->string('sgt_comentario');
            $table->integer('sgt_estado');
            $table->integer('sgt_usu_creacion');
            $table->timestamp('sgt_fecha_creacion')->useCurrent();
            $table->integer('sgt_usu_modificacion');
            $table->timestamp('sgt_fecha_modificacion')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sgt_seguimiento_tickets');
    }
}
