<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public $table = 'usuarios';

    protected $fillable = ['id', 'username', 'password'];
    //protected $hidden = ['password'];
}
