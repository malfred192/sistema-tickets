<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oauth_access_token extends Model
{
    use HasFactory;

    /*Llave primaria*/
    protected $primaryKey = 'id';
    /*Tabla*/
    protected $table = 'oauth_access_tokens';
}
