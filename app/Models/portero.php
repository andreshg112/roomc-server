<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class portero extends Model
{
    public $table = 'porteros';

    public $fillable = ['id', 'user_id', 'motel_id'];
}
