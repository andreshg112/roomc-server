<?php

namespace App\Models;

//Esto es lo que tenia el User.php que viene con Laravel.
//Por defecto JWT lo busca en App, pero aca esta en App\Models.
//Por eso se cambia en el jwt.php y auth.php
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable
{
	//use SoftDeletes; //Si no tiene la columna deleted_at sale error.
	// Por eso comente
    public $table = 'usuarios';

    protected $fillable = ['id', 'username', 'password'];
    //protected $hidden = ['password'];
}
