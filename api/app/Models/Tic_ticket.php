<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tic_ticket extends Model
{
    use HasFactory;

 //relacion uno a uno Nivel prioridad - Tickets
    public function nivel_prioridad()
    {
        return $this->belongsTo('App\Models\Nip_nivel_prioridad');
    }


    //relacion uno a uno Usuario - Tickets
    public function usuarios()
    {
        return $this->belongsTo('App\Models\User');
    }

    //relacion uno a muchos Tickets - Seguimineto de Tickets
    public function Seguimiento_tickets(){
        return $this->hasMany('App\Models\Sgt_seguimiento_ticket');
    }


    //relacion uno a muchos   Anexo Ticket -Ticket
    public function Seguimiento(){
        return $this->hasMany('App\Models\Ant_anexo_ticket');
    }

    
}
