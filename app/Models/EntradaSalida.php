<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class EntradaSalida extends Model
{
	public $table = 'entradas_salidas';

	protected $fillable = ['id', 'fecha_entrada', 'fecha_salida', 'tiempo', 'placa', 'tipo_vehiculo', 'color', 'marca', 'portero_id', 'habitacion_id'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	public function portero() {
		return $this->belongsTo(Portero::class);
	}
}
