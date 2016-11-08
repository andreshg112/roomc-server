<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoHabitacion extends Model
{
    public $table = 'tipo_habitaciones';
    
    public $fillable = ['id', 'nombre', 'costo_hora', 'costo_fraccion'];
    
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    public function motel()
    {
        return $this->belongsTo(Motel::class);
    }
}