<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol_rol extends Model
{
    use HasFactory;

    /*Llave primaria*/
    protected $primaryKey = 'rol_id';

    /*Asignamos el nombre de los campos para fechas de auditoria*/
    const CREATED_AT = 'rol_fecha_creacion';
    const UPDATED_AT = 'rol_fecha_modificacion';

    //relacion uno a muchos ROl - usuarios
    public function usuarios(){
        return $this->hasMany('App\Models\User');
    }

}
