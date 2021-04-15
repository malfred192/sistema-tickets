<?php

namespace App\Http\Controllers;

use App\Models\Tic_ticket;
use App\Models\Ant_anexo_ticket;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTicket;
use Illuminate\Support\Facades\Auth;


class TicketController extends Controller
{
    /**
     * Lista los registros de tickets del usuario logueado.
     * @param none
     * @return objeto json
     * @author Manuel Hernández
     * @since 2021-04-14
     * @method GET
     */
    public function index()
    {

        $tickets = Tic_ticket::select('tic_tickets.*', 'nip_nombre', 'est_nombre')
        ->leftjoin('nip_nivel_prioridads', 'nip_id', '=', 'tic_id_nip')
        ->leftjoin('sgt_seguimiento_tickets', 'sgt_id_tic', '=', 'tic_id')
        ->leftjoin('est_estado_tickets', 'est_id', '=', 'sgt_id_esc')
        ->where('tic_estado', 1)
        ->where('tic_id_usr',Auth::user()->usu_id)
        ->get();
        return $tickets;
    }



    /**
     * Función que regista los tickets del usuario. Además traslada los archivos adjuntos a la carpeta anexos_tickets en public.
     * @param Request Data de Formulario de tickets
     * @return true o false
     * @author Manuel Hernández
     * @since 2021-04-14
     * @method POST
     */
    public function store(Request $request)
    {
        $infoTicket=$request->all();
        $infoTicket['tic_id_usr']=Auth::user()->usu_id;
        $infoTicket['tic_estado']=1;
        $infoTicket['tic_usu_creacion']=Auth::user()->usu_id;
        $infoTicket['tic_usu_modificacion']=Auth::user()->usu_id;

        $idTicket=Tic_ticket::create($infoTicket);

        /*Almacenamos los archivos adjuntos si los hubiese*/
        $files = $request->file('files');
        foreach($files as $file){
           $nombreArchivo=$file->getClientOriginalName();
           $infoAnexo['ant_ruta']=$file->store('anexos_tickets','public');
           $infoAnexo['ant_id_tic']=$idTicket->tic_id;
           $infoAnexo['ant_nombre']=$nombreArchivo;
           $infoAnexo['ant_estado']=1;
           $infoAnexo['ant_usu_creacion']=Auth::user()->usu_id;
           $infoAnexo['ant_usu_modificacion']=Auth::user()->usu_id;
           Ant_anexo_ticket::create($infoAnexo);

           $url_file=explode("/", $infoAnexo['ant_ruta']);

           $nombreArchivo=end($url_file);
           $ruta=realpath(public_path("anexos_tickets"));
           $file->move($ruta,$nombreArchivo);
        }

        /*Obteniendo la data de los ficheros adjuntos*/
        $ficheros = Ant_anexo_ticket::select('*')
                ->where('ant_estado', 1)
                ->where('ant_id_tic',$idTicket->tic_id)
               ->get();

        if($idTicket->tic_id!=null){
            $info=array('res'=>true, 'tic_id'=>$idTicket->tic_id, 'files'=>$ficheros);
        }else{
            $info=array('res'=>false);
        }

        return json_encode($info);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tic_id)
    {
        $infoTickets=Tic_ticket::findOrFail($tic_id);
        $infoAnexos=Ant_anexo_ticket::select('*')
                        ->where('ant_estado',1)
                        ->where('ant_id_tic',$tic_id)
                        ->get();

        return array('info'=>$infoTickets, 'files'=>$infoAnexos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Busca los registros de acuerdo al parametro de busqueda.
     * @param Request Data de Formulario de busqueda de tickets
     * @return objeto con registros de tickets
     * @author Manuel Hernández
     * @since 2021-04-14
     * @method POST
     */
    public function buscarregistro(Request $info){

        if($info->estado!=null){
        $tickets = Tic_ticket::select('tic_tickets.*', 'nip_nombre', 'est_nombre','users.name')
                ->leftjoin('nip_nivel_prioridads', 'nip_id', '=', 'tic_id_nip')
                ->leftjoin('sgt_seguimiento_tickets', 'sgt_id_tic', '=', 'tic_id')
                ->leftjoin('est_estado_tickets', 'est_id', '=', 'sgt_id_esc')
                ->leftjoin('users', 'usu_id', '=', 'tic_id_usr')
                ->where('tic_estado', 1)
                ->where('tic_id_usr',Auth::user()->usu_id)
                ->titulo($info->titulo)
                ->prioridad($info->prioridad)
                ->date($info->fecha_inicio, $info->fecha_fin)
                ->estado($info->estado)
                ->get();
        }else{
            $tickets = Tic_ticket::select('tic_tickets.*', 'nip_nombre', 'users.name')
                ->leftjoin('nip_nivel_prioridads', 'nip_id', '=', 'tic_id_nip')
                ->leftjoin('users', 'usu_id', '=', 'tic_id_usr')
                ->estadoactual()
                ->where('tic_estado', 1)
                ->titulo($info->titulo)
                ->prioridad($info->prioridad)
                ->date($info->fecha_inicio, $info->fecha_fin)
                ->estado($info->estado)
                ->get();
        }
         
        return $tickets;

    }


    /**
     * Busca los registros de acuerdo al parametro de busqueda.
     * @param Request Data de Formulario de busqueda de tickets
     * @return objeto con registros de tickets
     * @author Manuel Hernández
     * @since 2021-04-14
     * @method POST
     */
    public function gestionar_tickets(Request $info){

       // dd($info->estado, $info->titulo, $info->prioridad, $info->fecha_inicio, $info->fecha_fin );

        if($info->estado!=null){
            $tickets = Tic_ticket::select('tic_tickets.*', 'nip_nombre', 'est_nombre','users.name')
                    ->leftjoin('nip_nivel_prioridads', 'nip_id', '=', 'tic_id_nip')
                    ->leftjoin('sgt_seguimiento_tickets', 'sgt_id_tic', '=', 'tic_id')
                    ->leftjoin('est_estado_tickets', 'est_id', '=', 'sgt_id_esc')
                    ->leftjoin('users', 'usu_id', '=', 'tic_id_usr')
                    ->where('tic_estado', 1)
                    ->titulo($info->titulo)
                    ->prioridad($info->prioridad)
                    ->date($info->fecha_inicio, $info->fecha_fin)
                    ->estado($info->estado)
                    ->get();
            }else{
                $tickets = Tic_ticket::select('tic_tickets.*', 'nip_nombre', 'users.name')
                    ->leftjoin('nip_nivel_prioridads', 'nip_id', '=', 'tic_id_nip')
                    ->leftjoin('users', 'usu_id', '=', 'tic_id_usr')
                    ->where('tic_estado', 1)
                    ->titulo($info->titulo)
                    ->prioridad($info->prioridad)
                    ->date($info->fecha_inicio, $info->fecha_fin)
                    ->estadoactual()
                    ->get();

            }











     /*   $tickets = Tic_ticket::select('tic_tickets.*', 'nip_nombre', 'users.name')
                ->leftjoin('nip_nivel_prioridads', 'nip_id', '=', 'tic_id_nip')
                ->estadoactual()
                ->leftjoin('users', 'usu_id', '=', 'tic_id_usr')
                ->where('tic_estado', 1)
                ->titulo($info->titulo)
                ->prioridad($info->prioridad)
                ->date($info->fecha_inicio, $info->fecha_fin)
                ->estado($info->estado)
                ->get();*/
         
        return $tickets;

    }

     /**
     * Lista los registros de tickets de todos los usuarios.
     * @param none
     * @return objeto json
     * @author Manuel Hernández
     * @since 2021-04-14
     * @method GET
     */
    public function get_tickets()
    {
        $tickets = Tic_ticket::select('tic_tickets.*', 'nip_nombre', 'users.name')
                ->leftjoin('nip_nivel_prioridads', 'nip_id', '=', 'tic_id_nip')
                ->leftjoin('users', 'usu_id', '=', 'tic_id_usr')
                ->estadoactual()
                ->where('tic_estado', 1)
                ->orderBy('tic_id', 'ASC')
               ->get();
        return $tickets;
    }

}
