<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable
{
    public $table = 'usuarios';
    
    protected $fillable = ['id', 'username', 'password', 'tipo_usuario', 'primer_nombre', 'segundo_nombre',
    'primer_apellido', 'segundo_apellido'];
    protected $hidden = ['password'];
    protected $dates = ['deleted_at'];
    
    public function administrador()
    {
        //El segundo parametro representa como se llama la llave en la otra tabla.
        //http://laraveles.com/docs/5.1/eloquent-relationships#one-to-one
        return $this->hasOne(Administrador::class, 'user_id');
    }
    
    public function portero()
    {
        return $this->hasOne(Portero::class, 'user_id');
    }
}