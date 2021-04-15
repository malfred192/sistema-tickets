<?php

namespace App\Http\Controllers;
use App\Models\Sgt_seguimiento_ticket;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class SeguimientoticketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $historicoTicket=$request->all();
        $historicoTicket['sgt_responsable']=Auth::user()->usu_id;
        $historicoTicket['sgt_estado']=1;
        $historicoTicket['sgt_usu_creacion']=Auth::user()->usu_id;
        $historicoTicket['sgt_usu_modificacion']=Auth::user()->usu_id;

        $idTicket=Sgt_seguimiento_ticket::create($historicoTicket);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return Sgt_seguimiento_ticket::select('sgt_seguimiento_tickets.*','est_nombre', 'users.name')
            ->leftjoin('est_estado_tickets', 'est_id', '=', 'sgt_id_esc')
            ->leftjoin('users', 'usu_id', '=', 'sgt_responsable')
        ->where('sgt_estado',1)
        ->where('sgt_id_tic',$id)
        ->get();
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
}
