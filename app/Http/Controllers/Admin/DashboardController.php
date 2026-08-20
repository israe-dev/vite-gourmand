<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;

class DashboardController extends Controller
{
    public function index()
    {
        // Optimisation : On peut lancer ces requêtes simples pour alimenter le dashboard
        $pendingOrdersCount = Commande::where('statut', 'en attente')->count();
        $onlineOrdersCount  = Commande::where('statut', 'accepté')->count(); 
        $instoreOrdersCount = Commande::where('statut', 'en préparation')->count(); 
        $allOrdersCount     = Commande::count();

        return view('admin.dashboard', compact(
            'pendingOrdersCount', 'onlineOrdersCount', 'instoreOrdersCount', 'allOrdersCount'
        ));
    }
}