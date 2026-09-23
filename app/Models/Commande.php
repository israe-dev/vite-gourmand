<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $table = 'commandes';

// Désactive le suivi automatique des dates de création et modification
    public $timestamps = false;

    protected $fillable = [
        'date_commande', 'date_prestation', 'heure_livraison',
        'lieu_livraison', 'nombre_personnes', 'prix_menu',
        'prix_livraison', 'prix_materiel', 'statut',
        'utilisateur_id', 'menu_id',
        // Payment fields
        'total', 'payment_status', 'payment_method', 'payment_provider_id', 'paid_at'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function avis()
    {
        return $this->hasOne(Avis::class, 'commande_id');
    }
}
