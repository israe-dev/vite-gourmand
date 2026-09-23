<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        // Récupère tous les thèmes triés par ordre alphabétique
        $themes = Theme::orderBy('libelle', 'asc')->get();
        return view('admin.themes', compact('themes'));
    }

    public function store(Request $request)
    {
        // Valide les données reçues (le libellé doit être unique)
        $request->validate([
            'libelle' => 'required|string|max:50|unique:themes,libelle',
        ], [
            'libelle.unique' => 'Ce thème existe déjà dans votre catalogue.',
        ]);

        // Crée le nouveau thème
        Theme::create([
            'libelle' => $request->libelle
        ]);

        return redirect()->back()->with('success', 'Le thème a été ajouté avec succès !');
    }

    public function destroy($id)
    {
        $theme = Theme::findOrFail($id);
        
        // Supprime le thème de la base de données
        $theme->delete();

        return redirect()->back()->with('success', 'Le thème a été retiré du catalogue.');
    }
}