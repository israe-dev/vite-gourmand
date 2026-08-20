<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // 1. Première validation de surface
        $request->validate([
            'menu_id'          => 'required|integer|exists:menus,id',
            'prix_menu'        => 'required|numeric',
            'lieu_livraison'   => 'required|string|max:200',
            'date_prestation'  => 'required|date|after_or_equal:today',
            'heure_livraison'  => 'required',
            'nombre_personnes' => 'required|integer',
        ]);

        // 2. Utilisation d'une transaction de base de données pour sécuriser le stock (Concurrency)
        try {
            $response = DB::transaction(function () use ($request) {
                
                // Récupération sécurisée du menu avec verrouillage (lockForUpdate)
                $menu = Menu::lockForUpdate()->findOrFail($request->input('menu_id'));

                // Vérification du stock disponible
                if ($menu->quantite_restante <= 0) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['stock' => 'Désolé, ce menu n\'est plus disponible (rupture de stock).']);
                }

                // Vérification dynamique du nombre minimum de personnes requis pour CE menu
                if ($request->input('nombre_personnes') < $menu->nb_personne_minimum) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['nombre_personnes' => "Ce menu nécessite un minimum de {$menu->nb_personne_minimum} personnes."]);
                }

                // 3. Calcul du prix total de base
                $prixTotal = $request->input('nombre_personnes') * $menu->prix_par_personne;

                // 4. Insertion de la commande
                DB::table('commandes')->insert([
                    'date_commande'    => now()->toDateString(),
                    'date_prestation'  => $request->input('date_prestation'),
                    'heure_livraison'  => $request->input('heure_livraison'),
                    'lieu_livraison'   => $request->input('lieu_livraison'),
                    'nombre_personnes' => $request->input('nombre_personnes'),
                    'prix_menu'        => $prixTotal,
                    'prix_livraison'   => 0.00, // Optionnel : À dynamiser plus tard
                    'prix_materiel'    => 0,
                    'statut'           => 'en attente',
                    'utilisateur_id'   => Auth::id(),
                    'menu_id'          => $menu->id,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);

                // 5. Décrémentation stricte du stock disponible
                $menu->decrement('quantite_restante');

                return null; // Tout s'est bien passé
            });

            if ($response instanceof \Illuminate\Http\RedirectResponse) {
                return $response;
            }

            return redirect()->route('customer.dashboard')
                ->with('success', 'Votre commande a bien été enregistrée et le stock a été mis à jour !');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de la réservation : ' . $e->getMessage()]);
        }
    }
}