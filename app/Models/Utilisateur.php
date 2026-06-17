<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;

    protected $table = 'utilisateurs';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'telephone',
        'adresse',
        'statut',
        'role_id'
    ];

    //sécurité RGPD
    protected $hidden = [
        'password',
    ];
}