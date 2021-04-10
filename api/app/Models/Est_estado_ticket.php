<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Est_estado_ticket extends Model
{
    use HasFactory;


    //relacion uno a muchos   Estado tickets - Seguimiento Tickets
    public function Seguimiento(){
        return $this->hasMany('App\Models\Sgt_seguimiento_ticket');
    }
}
