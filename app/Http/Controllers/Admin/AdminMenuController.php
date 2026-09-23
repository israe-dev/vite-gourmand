<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Theme;
use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMenuController extends Controller
{
    /**
     * Affiche la liste de tous les menus avec leurs thèmes et plats associés.
     */
    public function index()
    {
        $menus = Menu::with(['theme', 'plats'])->get();
        $themes = Theme::all();
        $plats = Plat::all();

        return view('admin.menus', compact('menus', 'themes', 'plats'));
    }

    /**
     * Enregistre un nouveau menu dans la base de données après validation.
     */
    public function store(Request $request)
    {
        // Validation des données envoyées par le formulaire
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

        // Création du menu
        $menu = Menu::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'nb_personne_minimum' => $request->nb_personne_minimum,
            'prix_par_personne' => $request->prix_par_personne,
            'conditions' => $request->conditions,
            'quantite_restante' => $request->quantite_restante,
            'theme_id' => $request->theme_id,
        ]);

        // Associe les plats sélectionnés au menu via la table pivot
        $menu->plats()->sync($request->plats);

        return redirect()->back()->with('success', 'Le menu a été configuré et associé à ses plats avec succès !');
    }

    /**
     * Affiche le formulaire pré-rempli pour modifier un menu existant.
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $themes = Theme::all();
        $plats = Plat::all();
        
        return view('admin.menus.edit', compact('menu', 'themes', 'plats'));
    }

    /**
     * Retourne les détails d'un menu spécifique au format JSON (pour affichage dynamique).
     */
    public function show($id)
    {
        $menu = Menu::with(['theme', 'plats'])->findOrFail($id);
        
        return response()->json($menu);
    }

    /**
     * Met à jour les informations d'un menu (et gère le remplacement de l'image si besoin).
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        // Validation des champs du formulaire de modification
        $request->validate([
            'titre' => 'required|string|max:100',
            'description' => 'nullable|string',
            'nb_personne_minimum' => 'required|integer|min:1',
            'prix_par_personne' => 'required|numeric|min:0',
            'conditions' => 'nullable|string',
            'quantite_restante' => 'required|integer|min:0',
            'theme_id' => 'nullable|exists:themes,id',
            'plats' => 'required|array',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Tableau des données à mettre à jour
        $updateData = [
            'titre' => $request->titre,
            'description' => $request->description,
            'nb_personne_minimum' => $request->nb_personne_minimum,
            'prix_par_personne' => $request->prix_par_personne,
            'conditions' => $request->conditions,
            'quantite_restante' => $request->quantite_restante,
            'theme_id' => $request->theme_id,
        ];

        // Gestion de l'upload d'une nouvelle photo
        if ($request->hasFile('photo')) {
            // Supprime l'ancienne image du serveur si elle existe
            if ($menu->photo && Storage::disk('public')->exists($menu->photo)) {
                Storage::disk('public')->delete($menu->photo);
            }
            // Enregistre la nouvelle image
            $updateData['photo'] = $request->file('photo')->store('menus', 'public');
        }

        // Mise à jour du menu en base de données
        $menu->update($updateData);

        // Met à jour la liste des plats associés dans la table pivot
        $menu->plats()->sync($request->plats);

        return redirect()->back()->with('success', 'Le menu a été modifié avec succès !');
    }

    /**
     * Supprime un menu du catalogue ainsi que ses liaisons avec les plats.
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        
        // Détache tous les plats avant de supprimer le menu
        $menu->plats()->detach();
        $menu->delete();

        return redirect()->back()->with('success', 'Le menu a été supprimé du catalogue.');
    }
}