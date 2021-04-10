<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('usu_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->unsignedBigInteger('usu_id_rol')->nullable();
            $table->foreign('usu_id_rol')
                    ->references('rol_id')->on('rol_rols')
                    ->onDelete('set null');
            $table->integer('usu_estado');
            $table->integer('usu_usu_creacion');
            $table->timestamp('usu_fecha_creacion')->useCurrent();
            $table->integer('usu_usu_modificacion');
            $table->timestamp('usu_fecha_modificacion')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
