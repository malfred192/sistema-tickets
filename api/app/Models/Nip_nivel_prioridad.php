<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nip_nivel_prioridad extends Model
{
    use HasFactory;

    //relacion uno a muchos
    public function tickets(){
        return $this->hasMany('App\Models\Tic_ticket');
    }
}
