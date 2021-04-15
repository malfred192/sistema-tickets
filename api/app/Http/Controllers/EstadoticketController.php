<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstadoTicket;
use App\Models\Est_estado_ticket;
use Illuminate\Http\Request;

class EstadoticketController extends Controller
{
    
     /**
     * Lista los registros de estados de tickets.
     * @param none
     * @return objeto json
     * @author Manuel Hernández
     * @since 2021-04-14
     * @method GET
     */
    public function index()
    {
        return Est_estado_ticket::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEstadoTicket $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function attributes()
    {
        return [
            'create_at'=>'Nombre de Estado'
        ];
    }
}
