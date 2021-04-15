<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tic_ticket extends Model
{
    use HasFactory;

     /*Llave primaria*/
     protected $primaryKey = 'tic_id';

     /*Asignamos el nombre de los campos para fechas de auditoria*/
     const CREATED_AT = 'tic_fecha_creacion';
     const UPDATED_AT = 'tic_fecha_modificacion';

    protected $fillable = ['tic_nombre', 'tic_id_usr', 'tic_descripcion', 'tic_id_nip', 'tic_estado', 'tic_usu_creacion', 'tic_usu_modificacion'];


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


    //Scopes 
    public function scopeTitulo($query, $titulo){
        if($titulo){
            return $query->where('tic_nombre','LIKE', "%$titulo%");
        }
    }

    public function scopePrioridad($query, $prioridad){
        if($prioridad){
            return $query->where('tic_id_nip', $prioridad);
        }
    }

    public function scopeDate($query, $fecha_inicio, $fecha_fin){

        if(date($fecha_inicio) != date($fecha_fin)){
        //return $query->whereBetween('tic_fecha_creacion', [date($fecha_inicio), date($fecha_fin)]);
        return $query->whereDate('tic_fecha_creacion', '>=', date($fecha_inicio))
                ->whereDate('tic_fecha_creacion', '<=', date($fecha_fin));

        }else if(date($fecha_inicio) == date($fecha_fin)){
           // return $query->where('tic_fecha_creacion', [date($fecha_inicio)]);
           return $query->whereDate('tic_fecha_creacion', '=', date($fecha_inicio));
        }
    }

    public function scopeEstado($query, $estado){

        if($estado){
        return $query->where('est_id', $estado);
        }
    }

    public function scopeEstadoactual($query){

       
        $subselect=Sgt_seguimiento_ticket::select('est_nombre')
            ->leftjoin('est_estado_tickets', 'est_id', '=', 'sgt_id_esc')
            ->whereColumn('sgt_seguimiento_tickets.sgt_id_tic', 'tic_tickets.tic_id')
            ->latest()
            ->limit(1);

        $query->addSelect([
            'est_nombre'=>$subselect,
        ]);
    }   
    


    
}
