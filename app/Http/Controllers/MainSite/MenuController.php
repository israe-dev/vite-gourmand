<?php

namespace App\Http\Controllers\MainSite;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Theme;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Affiche le catalogue des menus avec la gestion des filtres
    public function index(Request $request)
    {
    
        // Récupère tous les thèmes pour alimenter le filtre de la vue
        $themes = Theme::all();

        // Initialise la requête de base pour les menus
        $query = Menu::query();

        // Filtre par thème si une option est sélectionnée
        if ($request->filled('theme_id')) {
            $query->where('theme_id', $request->theme_id);
        }

        // Filtre par prix maximum si renseigné
        if ($request->filled('prix_max')) {
            $query->where('prix_par_personne', '<=', $request->prix_max);
        }

        // Filtre par mots-clés dans le titre ou la description
        if ($request->filled('recherche')) {
            $query->where(function($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->recherche . '%')
                  ->orWhere('description', 'like', '%' . $request->recherche . '%');
            });
        }

        // Récupère le résultat final des menus filtrés
        $menus = $query->get();

        // Retourne une réponse JSON si c'est un appel AJAX (pour rafraîchir dynamiquement)
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.menu-cards', compact('menus'))->render()
            ]);
        }

        // Sinon, affiche la page complète normalement
        return view('main-site.menus', compact('menus', 'themes'));
    }

    // Affiche la page de détail d'un menu donné
    public function show($id)
    {
        // Récupère le menu ou déclenche une erreur 404 s'il n'existe pas
        $menu = Menu::findOrFail($id);
        return view('main-site.menu-detail', compact('menu'));
    }
}