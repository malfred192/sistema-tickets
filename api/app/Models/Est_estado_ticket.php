<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Est_estado_ticket extends Model
{
    use HasFactory;

   /* protected $table = 'est_estado_tickets';*/
    protected $primaryKey = 'est_id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'est_fecha_creacion';
    
    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'est_fecha_modificacion';

    



    //relacion uno a muchos   Estado tickets - Seguimiento Tickets
    public function Seguimiento(){
        return $this->hasMany('App\Models\Sgt_seguimiento_ticket');
    }
}
