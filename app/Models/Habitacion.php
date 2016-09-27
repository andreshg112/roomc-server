<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    public $table = 'habitaciones';

	protected $fillable = ['id', 'numero', 'motel_id'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
