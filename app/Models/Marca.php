<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    public $table = 'marcas';

	protected $fillable = ['id', 'marca'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
