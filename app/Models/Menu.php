<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
  
    protected $table = 'menus';

 
    protected $fillable = [
        'titre',
        'description',
        'nb_personne_minimum',
        'prix_par_personne',
        'conditions',
        'quantite_restante',
        'theme_id',
        'regime_id'
    ];
}