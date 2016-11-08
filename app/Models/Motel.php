<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motel extends Model
{
    public $table = 'moteles';
    
    public $fillable = ['id', 'nombre', 'direccion', 'telefono',
    'administrador_id', 'tiene_anticipo', 'cobra_por_habitacion'];
    
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    public function administrador()
    {
        return $this->belongsTo(Administrador::class);
    }
}