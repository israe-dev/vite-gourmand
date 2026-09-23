<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Récupérer la commande active la plus récente 
        $activeOrder = $user->commandes()
            ->whereNotIn('statut', ['terminée', 'annulée'])
            ->latest()
            ->first();

        // Récupérer les 3 dernières commandes pour l'historique rapide sur le dashboard
        $recentOrders = $user->commandes()
            ->latest()
            ->take(3)
            ->get();

        return view('customer.dashboard', compact('activeOrder', 'recentOrders'));
    }
}