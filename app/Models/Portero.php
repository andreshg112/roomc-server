<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portero extends Model
{
    public $table = 'porteros';
    
    public $fillable = ['id', 'user_id', 'motel_id'];

    public function motel()
    {
        return $this->belongsTo(Motel::class);
    }
}