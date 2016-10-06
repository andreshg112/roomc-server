<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    public $table = 'administradores';
    public $fillable = ['id', 'user_id'];
    
    public function moteles()
    {
        return $this->hasMany(Motel::class);
    }
}