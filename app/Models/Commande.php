<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $table = 'commandes';
    protected $fillable = [
        'date_commande', 'date_prestation', 'heure_livraison', 
        'lieu_livraison', 'nombre_personnes', 'prix_menu', 
        'prix_livraison', 'prix_materiel', 'statut', 
        'utilisateur_id', 'menu_id'
    ];
}
