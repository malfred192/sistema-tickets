<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /*Llave primaria*/
    protected $primaryKey = 'usu_id';

    /*Asignamos el nombre de los campos para fechas de auditoria*/
    const CREATED_AT = 'usu_fecha_creacion';
    const UPDATED_AT = 'usu_fecha_modificacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'usu_id_rol',
        'usu_usu_creacion',
        'usu_usu_modificacion',
        'usu_estado'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token','email_verified_at', 'usu_usu_creacion', 'usu_usu_modificacion', 'usu_fecha_creacion', 'usu_fecha_modificacion'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    //relacion uno a muchos
    public function tickets(){
        return $this->belongsTo('App\Models\Tic_ticket');
    }


    //relacion uno a uno Usuario - Tickets
    public function roles()
    {
        return $this->belongsTo('App\Models\Rol_rol');
    }
}
