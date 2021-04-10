<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ant_anexo_ticket extends Model
{
    use HasFactory;

    //relacion uno a uno Anexo - Tickets
    public function tickets()
    {
        return $this->belongsTo('App\Models\Tic_ticket');
    }
}
