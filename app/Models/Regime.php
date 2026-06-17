<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regime extends Model
{
    protected $table = 'regimes';
    protected $fillable = ['libelle'];
}