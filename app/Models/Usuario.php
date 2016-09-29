<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable
{
    public $table = 'usuarios';

    protected $fillable = ['id', 'username', 'password'];
    protected $hidden = ['password'];
    protected $dates = ['deleted_at'];
}
