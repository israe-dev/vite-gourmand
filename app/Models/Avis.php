<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    protected $table = 'avis';
    protected $fillable = ['note', 'description', 'statut', 'commande_id'];
}
