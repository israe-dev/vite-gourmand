<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable;

    // On connecte explicitement le modèle à ta table en français
    protected $table = 'utilisateurs';

    /**
     * Les attributs insérables en masse (Mass Assignment)
     * Mix parfait entre tes colonnes SQL et la sécurité pro de la référence
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'telephone',
        'adresse',
        'statut',           // 1 = actif, 0 = inactif
        'role_id',          // Clé étrangère vers la table rôles
        'notice',           // Pour gérer les cas spécifiques (ex: "banned")
        'activation_token', // Pour le futur mail de confirmation
    ];

    /**
     * Les attributs masqués pour la sécurité (RGPD)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Le typage automatique de Laravel (Casting)
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Hachage automatique ultra-sécurisé
    ];

    /**
     * RELATION : Un utilisateur peut passer plusieurs commandes
     * (Inspiré de customerOrders() de ta référence)
     */
    public function commandes()
    {
        return $this->hasMany(Commande::class, 'utilisateur_id');
    }

    /**
     * RELATION : Un utilisateur possède un rôle (Client, Employé, Admin)
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}