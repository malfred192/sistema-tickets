<?php

namespace Database\Seeders;

use App\Models\Est_estado_ticket;
use Illuminate\Database\Seeder;

class SistemaTicketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $estadoTicket=new Est_estado_ticket();

       //Llenando la tabla con registros
       $estadoTicket->est_nombre="Nuevo";
       $estadoTicket->est_descripcion="Estado asignado por el administrador.";
       $estadoTicket->est_estado=1;
       $estadoTicket->est_usu_creacion=1;
       $estadoTicket->est_usu_modificacion=1;
       $estadoTicket->save();



    }
}
