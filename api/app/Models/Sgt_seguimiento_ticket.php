<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sgt_seguimiento_ticket extends Model
{
    use HasFactory;

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
