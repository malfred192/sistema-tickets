<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sgt_seguimiento_ticket extends Model
{
    use HasFactory;

    /*Llave primaria*/
    protected $primaryKey = 'sgt_id';

    /*Asignamos el nombre de los campos para fechas de auditoria*/
    const CREATED_AT = 'sgt_fecha_creacion';
    const UPDATED_AT = 'sgt_fecha_modificacion';

    protected $fillable = ['sgt_id','sgt_id_tic', 'sgt_id_esc', 'sgt_responsable', 'sgt_comentario','sgt_estado', 'sgt_usu_creacion', 'sgt_usu_modificacion'];

    //relacion uno a uno Usuario - Tickets
    public function tickets()
    {
        return $this->belongsTo('App\Models\Tic_ticket');
    }

    //relacion uno a uno Usuario - Tickets
    public function estado_ticket()
    {
        return $this->belongsTo('App\Models\Est_estado_ticket');
    }

    
}
