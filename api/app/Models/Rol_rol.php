<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol_rol extends Model
{
    use HasFactory;

    //relacion uno a muchos ROl - usuarios
    public function usuarios(){
        return $this->hasMany('App\Models\User');
    }

}
