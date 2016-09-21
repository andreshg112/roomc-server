<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motel extends Model
{
    public $table = 'moteles';

    public $fillable = ['id', 'nombre', 'direccion', 'telefono', 'administrador_id'];

    public function Usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}