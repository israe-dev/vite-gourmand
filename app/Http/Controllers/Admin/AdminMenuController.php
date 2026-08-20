<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Theme;
use App\Models\Plat;
use Illuminate\Http\Request;

class AdminMenuController extends Controller
{
    public function index()
    {
        // Récupère les menus avec leurs relations
        $menus = Menu::with(['theme', 'plats'])->get();
        $themes = Theme::all();
        $plats = Plat::all();

        return view('admin.menus', compact('menus', 'themes', 'plats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:100',
            'description' => 'nullable|string',
            'nb_personne_minimum' => 'required|integer|min:1',
            'prix_par_personne' => 'required|numeric|min:0',
            'conditions' => 'nullable|string',
            'quantite_restante' => 'required|integer|min:0',
            'theme_id' => 'nullable|exists:themes,id',
            'plats' => 'required|array'
        ]);

        $menu = Menu::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'nb_personne_minimum' => $request->nb_personne_minimum,
            'prix_par_personne' => $request->prix_par_personne,
            'conditions' => $request->conditions,
            'quantite_restante' => $request->quantite_restante,
            'theme_id' => $request->theme_id,
        ]);

        // Remplit la table pivot menu_plat automatiquement
        $menu->plats()->sync($request->plats);

        return redirect()->back()->with('success', 'Le menu a été configuré et associé à ses plats avec succès !');
    }

    /**
     * 1. CONSULTER LE MENU ET SES COMPOSANTS
     */
    public function show($id)
    {
        // On récupère le menu avec ses plats associés (ses composants)
        $menu = Menu::with(['theme', 'plats'])->findOrFail($id);
        
        // Si tu fais une requête AJAX/Fetch depuis ta vue pour afficher les détails dans une modale :
        return response()->json($menu);
    }

    /**
     * 2. MODIFIER LE MENU
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'titre' => 'required|string|max:100',
            'description' => 'nullable|string',
            'nb_personne_minimum' => 'required|integer|min:1',
            'prix_par_personne' => 'required|numeric|min:0',
            'conditions' => 'nullable|string',
            'quantite_restante' => 'required|integer|min:0',
            'theme_id' => 'nullable|exists:themes,id',
            'plats' => 'required|array'
        ]);

        // Mise à jour des informations du menu
        $menu->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'nb_personne_minimum' => $request->nb_personne_minimum,
            'prix_par_personne' => $request->prix_par_personne,
            'conditions' => $request->conditions,
            'quantite_restante' => $request->quantite_restante,
            'theme_id' => $request->theme_id,
        ]);

        // Synchronisation des plats modifiés dans la table pivot (ajoute les nouveaux, retire ceux décochés)
        $menu->plats()->sync($request->plats);

        return redirect()->back()->with('success', 'Le menu a été modifié avec succès !');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->plats()->detach();
        $menu->delete();

        return redirect()->back()->with('success', 'Le menu a été supprimé du catalogue.');
    }
}