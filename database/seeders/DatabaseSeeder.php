<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // On utilise bien le modèle User ici
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création de ton compte Admin de test connecté à la table rôles
        User::create([
            'nom' => 'ADMIN',
            'prenom' => 'Chef',
            'email' => 'admin@viteetgourmand.fr',
            'password' => Hash::make('Admin12345!'),
            'telephone' => '0600000000',
            'adresse' => '1 Rue de la Haute Cuisine, Bordeaux',
            'statut' => true,
            'role_id' => 1, // 1 = Admin selon ton diagramme de classes
        ]);
    }
}