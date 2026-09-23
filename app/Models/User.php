<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable;

    // Je dis à Laravel d'utiliser ma table "utilisateurs" en français
    protected $table = 'utilisateurs';

    // Tous les champs que j'ai le droit de remplir
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'telephone',
        'adresse',
        'statut',          // 1 = actif, 0 = inactif
        'role_id',         // Pour savoir si c'est un client, employé ou admin
        'notice',          // Pour bloquer un compte si besoin (ex: "banned")
        'activation_token', // Pour l'activation du compte
    ];

    // Ce qu'on préfère cacher pour que ça ne s'affiche pas n'importe où
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Pour que Laravel gère le mot de passe et la date tout seul
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Pour récupérer toutes les commandes de cet utilisateur
    public function commandes()
    {
        return $this->hasMany(Commande::class, 'utilisateur_id');
    }

    // Pour aller chercher à quel rôle est rattaché l'utilisateur
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}