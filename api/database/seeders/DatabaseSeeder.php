<?php

namespace Database\Seeders;

use App\Models\Est_estado_ticket;
use App\Models\Nip_nivel_prioridad;
use App\Models\Rol_rol;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       
        /* #################################################*/
        /* Table: est_estado_ticket                     */
        /* ################################################*/

        $estadoTicket=new Est_estado_ticket();

        $estadoTicket->est_nombre="Nuevo";
        $estadoTicket->est_descripcion="Estado asignado por el administrador.";
        $estadoTicket->est_orden=1;
        $estadoTicket->est_estado=1;
        $estadoTicket->est_usu_creacion=1;
        $estadoTicket->est_usu_modificacion=1;
        $estadoTicket->save();

        $estadoTicket=new Est_estado_ticket();
        $estadoTicket->est_nombre="En Proceso";
        $estadoTicket->est_descripcion="Estado cuando pasa a En Proceso";
        $estadoTicket->est_orden=2;
        $estadoTicket->est_estado=1;
        $estadoTicket->est_usu_creacion=1;
        $estadoTicket->est_usu_modificacion=1;
        $estadoTicket->save();

        $estadoTicket=new Est_estado_ticket();
        $estadoTicket->est_nombre="En Espera";
        $estadoTicket->est_descripcion="Estado el proceso esta en lista de espera";
        $estadoTicket->est_orden=3;
        $estadoTicket->est_estado=1;
        $estadoTicket->est_usu_creacion=1;
        $estadoTicket->est_usu_modificacion=1;
        $estadoTicket->save();
 
        $estadoTicket=new Est_estado_ticket();
        $estadoTicket->est_nombre="Resuelto";
        $estadoTicket->est_descripcion="Estado el proceso esta en lista de espera";
        $estadoTicket->est_orden=4;
        $estadoTicket->est_estado=1;
        $estadoTicket->est_usu_creacion=1;
        $estadoTicket->est_usu_modificacion=1;
        $estadoTicket->save();


         /* #################################################*/
        /* Table: nip_nivel_prioridads                     */
        /* ################################################*/
        $prioridadTicket=new Nip_nivel_prioridad();
        $prioridadTicket->nip_nombre='Bajo';
        $prioridadTicket->nip_descripcion='Nivel prioridad Bajo';
        $prioridadTicket->nip_estado=1;
        $prioridadTicket->nip_usu_creacion=1;
        $prioridadTicket->nip_usu_modificacion=1;
        $prioridadTicket->save();

        $prioridadTicket=new Nip_nivel_prioridad();
        $prioridadTicket->nip_nombre='Normal';
        $prioridadTicket->nip_descripcion='Nivel prioridad normal';
        $prioridadTicket->nip_estado=1;
        $prioridadTicket->nip_usu_creacion=1;
        $prioridadTicket->nip_usu_modificacion=1;
        $prioridadTicket->save();

        $prioridadTicket=new Nip_nivel_prioridad();
        $prioridadTicket->nip_nombre='Alto';
        $prioridadTicket->nip_descripcion='nivel prioridad Alto';
        $prioridadTicket->nip_estado=1;
        $prioridadTicket->nip_usu_creacion=1;
        $prioridadTicket->nip_usu_modificacion=1;
        $prioridadTicket->save();

        $prioridadTicket=new Nip_nivel_prioridad();
        $prioridadTicket->nip_nombre='Urgente';
        $prioridadTicket->nip_descripcion='nivel Prioridad Urgente';
        $prioridadTicket->nip_estado=1;
        $prioridadTicket->nip_usu_creacion=1;
        $prioridadTicket->nip_usu_modificacion=1;
        $prioridadTicket->save();


        /* #################################################*/
        /* Table: rol_rols                     */
        /* ################################################*/
        $rolUsuario=new Rol_rol();
        $rolUsuario->rol_nombre='Administrador';
        $rolUsuario->rol_descripcion='Usuario con rol de administrador del sistema. Tiene acceso total al sistema';
        $rolUsuario->rol_estado=1;
        $rolUsuario->rol_usu_creacion=1;
        $rolUsuario->rol_usu_modificacion=1;
        $rolUsuario->save();

        $rolUsuario=new Rol_rol();
        $rolUsuario->rol_nombre='Usuario Final';
        $rolUsuario->rol_descripcion='Usuario que tiene acceso restringido al sistema. Solamente puede registrar tickets y consultarlos.';
        $rolUsuario->rol_estado=1;
        $rolUsuario->rol_usu_creacion=1;
        $rolUsuario->rol_usu_modificacion=1;
        $rolUsuario->save();

    }
}
