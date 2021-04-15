<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ant_anexo_ticket extends Model
{
    use HasFactory;

    /*Llave primaria*/
    protected $primaryKey = 'ant_id';

    /*Asignamos el nombre de los campos para fechas de auditoria*/
    const CREATED_AT = 'ant_fecha_creacion';
    const UPDATED_AT = 'ant_fecha_modificacion';

    protected $fillable = ['ant_id','ant_nombre', 'ant_id_tic', 'ant_ruta', 'ant_estado', 'ant_usu_creacion', 'ant_usu_modificacion'];

    //relacion uno a uno Anexo - Tickets
    public function tickets()
    {
        return $this->belongsTo('App\Models\Tic_ticket');
    }
}
