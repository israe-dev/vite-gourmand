<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // Pour enregistrer des services ou des liaisons au démarrage de l'application
    public function register(): void
    {
        // Rien pour l'instant
    }

    // Pour initialiser des configurations globales une fois que tout est chargé
    public function boot(): void
    {
        // Rien pour l'instant
    }
}