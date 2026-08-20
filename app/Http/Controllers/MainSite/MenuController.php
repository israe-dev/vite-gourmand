<?php

namespace App\Http\Controllers\MainSite;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Theme;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Affiche la page des menus avec les filtres
     */
    public function index(Request $request)
    {
        dd('cc');
        // On récupère les thèmes pour alimenter la liste déroulante du formulaire de filtre
        $themes = Theme::all();

        // On commence notre requête sans restriction pour afficher tous les menus au chargement
        $query = Menu::query();

        // FILTRE : Par thème (si sélectionné)
        if ($request->filled('theme_id')) {
            $query->where('theme_id', $request->theme_id);
        }

        // FILTRE : Par prix maximum (si renseigné)
        if ($request->filled('prix_max')) {
            $query->where('prix_par_personne', '<=', $request->prix_max);
        }

        // FILTRE : Par recherche textuelle (titre ou description)
        if ($request->filled('recherche')) {
            $query->where(function($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->recherche . '%')
                  ->orWhere('description', 'like', '%' . $request->recherche . '%');
            });
        }

        // On récupère les menus filtrés
        $menus = $query->get();

        // Si la requête est une requête AJAX/Fetch, on renvoie uniquement du JSON
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.menu-cards', compact('menus'))->render()
            ]);
        }

        // Sinon, on charge la page complète normalement
        return view('main-site.menus', compact('menus', 'themes'));
    }

    /**
     * Affiche le détail d'un menu spécifique
     */
    public function show($id)
    {
        // On charge le menu ou on renvoie une erreur 404 s'il n'existe pas
        $menu = Menu::findOrFail($id);
        return view('main-site.menu-detail', compact('menu'));
    }
}