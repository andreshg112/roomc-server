<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moteles extends Model
{
    public $table = 'moteles';

    public $fillable = ['id', 'nombre', 'direccion', 'telefono', 'administrador_id'];
}
