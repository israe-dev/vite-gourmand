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

    // Relation : Un menu possède plusieurs plats
    public function plats()
    {
        return $this->belongsToMany(Plat::class, 'menu_plat', 'menu_id', 'plat_id');
    }

    // Relation : Un menu appartient à un thème (pour les filtres et l'affichage)
    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }
}