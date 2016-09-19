<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    public $table = 'administradores';

    public $fillable = ['id', 'user_id'];

    public function Usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

        public function administrador($user_id)
    {
        return $this->belongsTo(Usuario::class);
    }
}
