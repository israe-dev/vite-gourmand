<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plat extends Model
{
    protected $table = 'plats';
    protected $fillable = ['nom', 'type', 'photo'];
}