<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tic_tickets', function (Blueprint $table) {
            $table->id('tic_id');
            $table->string('tic_nombre')->unique();
            $table->string('tic_descripcion');
            $table->unsignedBigInteger('tic_id_nip')->nullable();
            $table->foreign('tic_id_nip')
                    ->references('nip_id')->on('Nip_nivel_prioridads')
                    ->onDelete('set null');
            $table->unsignedBigInteger('tic_id_usr')->nullable();
            $table->foreign('tic_id_usr')
                    ->references('usu_id')->on('Users')
                    ->onDelete('set null');
            $table->integer('tic_estado');
            $table->integer('tic_usu_creacion');
            $table->timestamp('tic_fecha_creacion')->useCurrent();
            $table->integer('tic_usu_modificacion');
            $table->timestamp('tic_fecha_modificacion')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tic_tickets');
    }
}
