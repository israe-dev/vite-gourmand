<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergene extends Model
{
    protected $table = 'allergenes';
    protected $fillable = ['libelle'];
}
