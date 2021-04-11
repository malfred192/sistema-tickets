<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nip_nivel_prioridad extends Model
{
    use HasFactory;

    /*Llave primaria*/
    protected $primaryKey = 'nip_id';

    /*Asignamos el nombre de los campos para fechas de auditoria*/
    const CREATED_AT = 'nip_fecha_creacion';
    const UPDATED_AT = 'nip_fecha_modificacion';
    

    //relacion uno a muchos
    public function tickets(){
        return $this->hasMany('App\Models\Tic_ticket');
    }

    protected $fillable = ['nip_nombre', 'nip_descripcion', 'nip_estado', 'nip_usu_creacion', 'nip_usu_modificacion'];

    protected $hidden=[
        'nip_usu_creacion', 'nip_usu_modificacion', 'nip_fecha_creacion', 'nip_fecha_modificacion'
    ];
}
